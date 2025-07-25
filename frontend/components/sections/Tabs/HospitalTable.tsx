import { useEffect, useState } from "react";
import { IoMdArrowDown, IoMdArrowBack, IoMdArrowForward } from "react-icons/io";
import dynamic from "next/dynamic";
import DetailsModal from "./DetailsModal";
const DataTable = dynamic(() => import("react-data-table-component"), {
  ssr: false,
});

//@ts-ignore
const DataTableExtensions = dynamic(
  () => import("react-data-table-component-extensions"),
  { ssr: false }
);

import "react-data-table-component-extensions/dist/index.css";
import { useRouter, useSearchParams } from "next/navigation";

const HospitalTable: React.FC<{
  data: any[];
  currentPage: number;
  setCurrentPage: (page: number) => void;
  totalPages: number;
  totalRecords: number;
  entriesPerPage: number;
  // fetchFacilities: (page: number) => void; // Fetch facilities based on the page
}> = ({
  data,
  currentPage,
  setCurrentPage,
  totalPages,
  totalRecords,
  entriesPerPage,
  // fetchFacilities,
}) => {
  const [loading, setLoading] = useState(true);

  const [showModal, setShowModal] = useState(false);
  const [selectedRow, setSelectedRow] = useState(null);

  const searchParams = useSearchParams();
  const [isVerified, setIsVerified] = useState(false);

  const router = useRouter();

  const openModal = (row: any) => {
    setSelectedRow(row);
    setShowModal(true);
  };

  const closeModal = () => {
    setShowModal(false);
    setSelectedRow(null);
  };

  useEffect(() => {
    if (data.length > 0) {
      setLoading(false); // Data is loaded
    }
  }, [data]);

  // console.log({
  //   entriesPerPage,
  //   type: typeof entriesPerPage,
  // });

  // console.log({ tofunmi: data });

  const columns = [
    // {
    //   name: "#",
    //   selector: (row: any, index: number) =>
    //     (currentPage - 1) * entriesPerPage + (index + 1), // Calculate serial number
    //   sortable: false, // No need to sort by serial number
    // },
    {
      name: "State",
      selector: (row: any) => row.state_name,
      sortable: true,
    },
    {
      name: "LGA",
      selector: (row: any) => row.lga_name,
      sortable: true,
    },
    {
      name: "Ward",
      selector: (row: any) => row.ward_name ?? "N/A",
      sortable: true,
    },
    {
      name: "Facility Name",
      selector: (row: any) => row.facility_name,
      sortable: true,
      wrap: true, // ✅ Ensures wrapping
      grow: 2, // ✅ Increases width to take more space
    },
    {
      name: "Facility Level",
      selector: (row: any) => row.facility_level_name,
      sortable: true,
      cell: (row: any) => (
        <span
          className={`px-2 py-1 rounded-sm text-white text-sm font- ${
            row.facility_level_name === "Primary"
              ? "bg-green-500"
              : row.facility_level_name === "Secondary"
              ? "bg-blue-500"
              : row.facility_level_name === "Tertiary"
              ? "bg-gray-500"
              : "bg-red-500"
          }`}
        >
          {row.facility_level_name}
        </span>
      ),
    },
    {
      name: "Ownership",
      selector: (row: any) => row.ownership_name,
      sortable: true,
      cell: (row: any) => (
        <span
          className={`px-2 py-1 rounded-sm text-white text-sm font- ${
            row.ownership_name === "Public"
              ? "bg-indigo-500"
              : row.ownership_name === "Private"
              ? "bg-cyan-500"
              : "bg-red-500"
          }`}
        >
          {row.ownership_name}
        </span>
      ),
    },

    {
      name: "Details",
      cell: (row: any) => (
        <span
          onClick={() => openModal(row)}
          className="text-green-600 underline cursor-pointer"
        >
          Details
        </span>
      ),
    },
  ];

  const customStyles = {
    headRow: {
      style: {
        backgroundColor: "#E8F0E2", // Header background color
        color: "#333", // Text color
        fontSize: "14px", // Header font size
        fontWeight: "bold", // Bold header text
      },
    },
    headCells: {
      style: {
        fontSize: "14px", // Column header font size
        fontWeight: "bold",
      },
    },
    rows: {
      style: {
        fontSize: "14px", // Row data font size
      },
    },
    cells: {
      style: {
        fontSize: "14px",
        whiteSpace: "normal", // ✅ Allow text to wrap
        overflow: "visible", // ✅ Prevent truncation
      },
    },
  };

  const tableData = {
    columns,
    data,
  };

  // Pagination calculations
  // const totalRecords = Math.ceil(totalPages / 5); // Assuming 5 records per page

  // console.log({ "adams lagos": entriesPerPage, currentPage, totalPages });

  const exportToCSV = (data: any[], filename: string) => {
    if (!data.length) return;

    const csvRows = [];

    // Extract headers
    const headers = Object.keys(data[0]);
    csvRows.push(headers.join(","));

    // Extract rows
    for (const row of data) {
      const values = headers.map((header) => JSON.stringify(row[header] ?? ""));
      csvRows.push(values.join(","));
    }

    const csvData = new Blob([csvRows.join("\n")], { type: "text/csv" });
    const url = window.URL.createObjectURL(csvData);

    const link = document.createElement("a");
    link.href = url;
    link.download = `${filename}.csv`;
    link.click();

    window.URL.revokeObjectURL(url);
  };

  useEffect(() => {
    const verified = searchParams.get("verified");

    if (verified === "true") {
      const now = new Date().toISOString();
      localStorage.setItem("verified", "true");
      localStorage.setItem("verified_at", now);
      setIsVerified(true);

      // Remove query param
      window.history.replaceState({}, document.title, window.location.pathname);
    } else {
      const verifiedFlag = localStorage.getItem("verified");
      const verifiedAt = localStorage.getItem("verified_at");

      if (verifiedFlag === "true" && verifiedAt) {
        const now = new Date();
        const savedTime = new Date(verifiedAt);
        const diffInMs = now.getTime() - savedTime.getTime();
        const diffInHours = diffInMs / (1000 * 60);
        const thresholdMinutes = parseFloat(
          process.env.NEXT_PUBLIC_VERIFICATION_EXPIRY_MINUTES || "15"
        );

        // const diffInHours = diffInMs / (1000 * 60);
        console.log({
          thresholdMinutes,
          diffInHours,
          verifiedAt,
          now,
          savedTime,
        });

        if (diffInHours < thresholdMinutes) {
          setIsVerified(true);
        } else {
          // Expired: clear it
          localStorage.removeItem("verified");
          localStorage.removeItem("verified_at");
        }
      }
    }
  }, [searchParams]);

  console.log({ data });

  return (
    <>
      <div className="mt-6">
        <DataTable
          highlightOnHover
          columns={columns}
          customStyles={customStyles}
          striped
          data={data}
          pagination
          paginationServer
          paginationTotalRows={totalRecords}
          paginationPerPage={entriesPerPage}
          paginationComponentOptions={{
            noRowsPerPage: true,
          }}
          paginationDefaultPage={currentPage}
          onChangePage={(page) => setCurrentPage(page)}
          progressPending={loading}
        />
        {showModal && selectedRow && (
          <DetailsModal row={selectedRow} onClose={closeModal} />
        )}
      </div>
      <hr className="border-[#f1f1f1] mt-5" />
      {/* 
      <div className="flex justify-center pt-5 mb-4 text-center">
        <button
          onClick={() => exportToCSV(data, "hospital_report")}
          className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Download CSV
        </button>
      </div> */}
      {/* {isVerified && (
        <div className="flex justify-center pt-5 mb-4 text-center">
          <button
            onClick={() => exportToCSV(data, "hospital_report")}
            className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            disabled={!isVerified}
          >
            Download CSV
          </button>
        </div>
      )} */}

      {isVerified ? (
        <div className="flex justify-center pt-5 mb-4 text-center">
          <button
            onClick={() => exportToCSV(data, "hospital_report")}
            className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Download CSV
          </button>
        </div>
      ) : (
        <div className="flex justify-center pt-5 mb-4 text-center">
          <button
            onClick={() => router.push("/datadownloads")}
            className="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
          >
            Download CSV
          </button>
        </div>
      )}
    </>
  );
};

export default HospitalTable;
