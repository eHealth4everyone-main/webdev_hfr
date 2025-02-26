import { useEffect, useState } from "react";
import { IoMdArrowDown, IoMdArrowBack, IoArrowForward } from "react-icons/io";

import dynamic from "next/dynamic";
const DataTable = dynamic(() => import("react-data-table-component"), {
  ssr: false,
});
const DataTableExtensions = dynamic(
  () => import("react-data-table-component-extensions"),
  { ssr: false }
);

const PharmaceuticalTable = ({
  data,
  currentPage,
  setCurrentPage,
  totalPages,
  fetchFacilities,
}) => {
  const [search, setSearch] = useState("");
  const [filteredData, setFilteredData] = useState(data);

  // Handle search input change
  const handleSearch = (event) => {
    const value = event.target.value.toLowerCase();
    setSearch(value);

    const filteredResults = data.filter((facility) =>
      facility.facility_name.toLowerCase().includes(value)
    );

    setFilteredData(filteredResults);
  };

  const columns = [
    {
      name: "State",
      selector: (row) => row.state_name,
      sortable: true,
    },
    {
      name: "LGA",
      selector: (row) => row.lga_name,
      sortable: true,
    },
    {
      name: "Ward",
      selector: (row) => row.ward_name ?? "N/A",
      sortable: true,
    },
    {
      name: "Facility Name",
      selector: (row) => row.facility_name,
      sortable: true,
    },

    {
      name: "Ownership",
      selector: (row) => row.ownership_name,
      sortable: true,
      cell: (row) => (
        <span
          className={`px-2 py-1 rounded-md text-white text-sm font-semibold ${
            row.ownership_name === "Public"
              ? "bg-green-600"
              : row.ownership_name === "Private"
              ? "bg-red-500"
              : "bg-gray-500"
          }`}
        >
          {row.ownership_name}
        </span>
      ),
    },
    {
      name: "Details",
      cell: () => (
        <span className="text-[#5BBA62] text-sm underline cursor-pointer">
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
        fontSize: "18px", // Header font size
        fontWeight: "bold", // Bold header text
      },
    },
    headCells: {
      style: {
        fontSize: "18px", // Column header font size
        fontWeight: "bold",
      },
    },
    rows: {
      style: {
        fontSize: "16px", // Row data font size
      },
    },
    cells: {
      style: {
        fontSize: "16px", // Individual cell font size
      },
    },
  };

  const tableData = {
    columns,
    data,
  };

  return (
    <div className="mt-6">
      <DataTableExtensions
        {...tableData}
        export={false}
        print={false}
        filter={true}
        filterPlaceholder="Search Facilities name"
      >
        <DataTable
          highlightOnHover
          columns={columns}
          customStyles={customStyles}
          striped
          data={data}
          pagination
          paginationServer
          paginationTotalRows={totalPages * 15} // Laravel sends per_page: 10
          paginationPerPage={15}
          // paginationPerPage={10}
          paginationComponentOptions={{
            noRowsPerPage: true,
          }}
          onChangePage={(page) => setCurrentPage(page)}
        />
      </DataTableExtensions>
    </div>
  );
};

export default PharmaceuticalTable;
