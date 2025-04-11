import Input from "@/components/ui/Input";
import SelectComponent from "@/components/ui/SelectComponent";
import { GreenButton, Text } from "@/components/ui/Typography";
import React, {
  useCallback,
  useEffect,
  useMemo,
  useRef,
  useState,
} from "react";
// import HospitalTable from "./HospitalTable";
import dynamic from "next/dynamic";
const HospitalTable = dynamic(() => import("./HospitalTable"), { ssr: false });

import axios from "axios";
import SelectComponent3 from "@/components/ui/SelectComponent3";

const HospitalTab = () => {
  const [states, setStates] = useState<any[]>([]); // Store states
  const [lgas, setLgas] = useState<any[]>([]); // Store LGAs
  const [wards, setWards] = useState<any[]>([]); // Store wards
  const [facilityLevels, setFacilityLevel] = useState<any[]>([]);

  const [ownerships, setOwnership] = useState<any[]>([]);
  const [ownershipCategories, setOwnershipCategories] = useState<any[]>([]);
  // const [ownershipCategories, setOwnershipCategories] = useState<
  //   { id: string; name: string }[]
  // >([]);

  const [operationals, setOperational] = useState<any[]>([]);
  const [registrations, setRegistration] = useState<any[]>([]);
  const [licenses, setLicense] = useState<any[]>([]);
  const [serviceCategories, setServiceCategory] = useState<any[]>([]);
  const [services, setService] = useState<any[]>([]);

  const [selectedState, setSelectedState] = useState(""); // Selected state
  const [selectedLga, setSelectedLga] = useState(""); // Selected LGA
  const [selectedWard, setSelectedWard] = useState("");
  const [selectedFacilityLevel, setSelectedFacilityLevel] = useState("");

  const [selectedownership, setSelectedownership] = useState("");
  const [selectedOwnershipCategory, setSelectedOwnershipCategory] =
    useState("");

  const [selectedOperational, setSelectedOperational] = useState("");
  const [selectedRegistration, setSelectedRegistration] = useState("");
  const [selectedLicense, setSelectedLicense] = useState("");

  const [selectedServiceCategory, setSelectedServiceCategory] = useState("");
  const [selectedService, setSelectedService] = useState("");
  const [fetchError, setFetchError] = useState<string>(""); // State for error messages

  const [selectedGeoCode, setSelectedGeoCode] = useState("");
  const [selectedServiceType, setSelectedServiceType] = useState("0");

  const [loading, setLoading] = useState<boolean>(true); // Loading state

  const [data, setData] = useState([]); // Store API response
  const [currentPage, setCurrentPage] = useState(1); // Track pagination
  const [totalPages, setTotalPages] = useState(1); // Store total pages
  const [totalRecords, setTotalRecords] = useState(1); // Store total pages

  const searchInputRef = useRef<HTMLInputElement>(null);

  const [search, setSearch] = useState("");
  // const [entriesPerPage, setEntriesPerPage] = useState(25); // Entries per page state

  // const entryPerPage = [
  //   // { id: "25", name: "25" },
  //   { id: "50", name: "50" },
  //   { id: "100", name: "100" },
  //   { id: "150", name: "150" },
  //   { id: "200", name: "200" },
  // ];

  const entryPerPage = useMemo(
    () => [
      { id: "50", name: "50" },
      { id: "100", name: "100" },
      { id: "150", name: "150" },
      { id: "200", name: "200" },
    ],
    []
  );

  const [entriesPerPage, setEntriesPerPage] = useState<number>(() => {
    return parseInt(entryPerPage[0].id); // Ensures it's a number
  });

  useEffect(() => {
    if (typeof window !== "undefined") {
      const storedValue = localStorage.getItem("entriesPerPage");
      if (storedValue) {
        setEntriesPerPage(parseInt(storedValue));
      }
    }
  }, []);

  const fetchFacilities = useCallback(async () => {
    setLoading(true);
    setFetchError("");

    // Log the parameters being sent to the backend
    console.log({
      state_id: selectedState,
      lga_id: selectedLga,
      ward_id: selectedWard,
      facility_level_id: selectedFacilityLevel,
      ownership_id: selectedownership,
      ownership_type_id: selectedOwnershipCategory,
      operational_status_id: selectedOperational,
      registration_status_id: selectedRegistration,
      license_status_id: selectedLicense,
      outpatient: selectedServiceType ? 1 : 0,
      inpatient: selectedServiceType ? 1 : 0,
      geo_codes: selectedGeoCode,
      service_category_id: selectedServiceCategory,
      services: selectedService,
      page: currentPage,
      per_page: entriesPerPage,
    });

    try {
      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facilities-hospitals-search`,
        {
          state_id: selectedState,
          lga_id: selectedLga,
          ward_id: selectedWard,
          facility_level_id: selectedFacilityLevel,
          ownership_id: selectedownership,
          ownership_type_id: selectedOwnershipCategory,
          operational_status_id: selectedOperational,
          registration_status_id: selectedRegistration,
          license_status_id: selectedLicense,
          outpatient: selectedServiceType ? 1 : 0,
          inpatient: selectedServiceType ? 1 : 0,
          geo_codes: selectedGeoCode,

          service_category_id: selectedServiceCategory,
          services: selectedService,
          // facility_name: search,
          page: currentPage,
          per_page: entriesPerPage,
        }
      );

      console.log("response by adams", response.data.data.facilities);

      // After fetching, update total records and total pages
      const fetchedData = response.data?.data?.facilities?.data;
      const totalRecords = response.data?.data?.facilities?.total;

      // Set new data and calculate total pages based on entriesPerPage
      setData(fetchedData); // Set fetched data
      setTotalRecords(totalRecords); // Set total records from API
      // setTotalPages(response.data?.data?.facilities?.last_page); // Set total pages from API

      const calculatedTotalPages = Math.ceil(totalRecords / entriesPerPage); // Recalculate total pages based on entriesPerPage
      setTotalPages(calculatedTotalPages); // Update total pages
      // console.log("calculatedTotalPages by adams", calculatedTotalPages);
    } catch (error) {
      console.error("Error fetching data:", error);
    } finally {
      setLoading(false); // Ensure loading stops
    }
  }, [
    currentPage,
    selectedState,
    selectedLga,
    selectedWard,
    selectedFacilityLevel,
    selectedownership,
    selectedOwnershipCategory,
    selectedOperational,
    selectedRegistration,
    selectedLicense,
    selectedServiceType,
    entriesPerPage,
    selectedGeoCode,
    selectedServiceCategory,
    selectedService,
  ]);

  const fetchFacilities2 = useCallback(async () => {
    setLoading(true);
    setFetchError("");

    try {
      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facilities-hospitals-search`,
        {
          facility_name: search, // Include facility name search
          per_page: entriesPerPage, // Send number of entries per page
          page: currentPage,
        }
      );

      // setData(response.data?.data?.facilities?.data);
      // setTotalPages(response.data?.data?.facilities?.last_page);

      // After fetching, update total records and total pages
      const fetchedData = response.data?.data?.facilities?.data;
      const totalRecords = response.data?.data?.facilities?.total;

      // Set new data and calculate total pages based on entriesPerPage
      setData(fetchedData); // Set fetched data
      setTotalRecords(totalRecords); // Set total records from API
      // setTotalPages(response.data?.data?.facilities?.last_page); // Set total pages from API

      const calculatedTotalPages = Math.ceil(totalRecords / entriesPerPage); // Recalculate total pages based on entriesPerPage
      setTotalPages(calculatedTotalPages); // Update total pages
      console.log("calculatedTotalPages by daniel", calculatedTotalPages);
    } catch (error) {
      setFetchError("Failed to fetch hospitals");
      console.error("Error fetching hospitals:", error);
    }

    setLoading(false);
  }, [search, entriesPerPage, currentPage]);

  // Fetch states
  const fetchStates = useCallback(async () => {
    setLoading(true);
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/states`
      );
      const data = response?.data?.data; // Axios automatically parses JSON

      // console.log("response", data);

      if (data && Array.isArray(data)) {
        setStates(data);
      }
    } catch (error) {
      console.error("Error fetching states:", error);
      // setFetchError("Failed to fetch states.");
    } finally {
      setLoading(false);
    }
  }, []);

  // Fetch LGAs based on selected state
  const fetchLgas = useCallback(async (stateId: string) => {
    try {
      setLgas([]); // Reset LGAs
      setWards([]); // Reset wards
      setSelectedLga(""); // Reset selected LGA

      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/lgas-by-state`,
        { state_id: stateId },
        { headers: { "Content-Type": "application/json" } }
      );

      const data = response?.data?.data;

      if (data && Array.isArray(data)) {
        setLgas(data);
      }
    } catch (error) {
      console.error("Error fetching LGAs:", error);
      setFetchError("Failed to fetch LGAs.");
    }
  }, []);

  // Fetch wards based on selected LGA
  const fetchWards = useCallback(async (lgaId: string) => {
    try {
      setWards([]); // Reset wards

      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/ward-by-lga`,
        { lga_id: lgaId },
        { headers: { "Content-Type": "application/json" } }
      );
      const data = response?.data?.data;

      if (data && Array.isArray(data)) {
        setWards(data);
      }
    } catch (error) {
      console.error("Error fetching wards:", error);
      setFetchError("Failed to fetch wards.");
    }
  }, []);

  // Fetch facilityLevel
  const facilityLevel = useCallback(async () => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facility-level`
      );
      const data = response?.data?.data; // Axios automatically parses JSON

      // console.log("response", data);

      if (data && Array.isArray(data)) {
        setFacilityLevel(data);
      }
    } catch (error) {
      console.error("Error fetching facility-level:", error);
      // setFetchError("Failed to fetch facility-level.");
    } finally {
      setLoading(false);
    }
  }, []);

  // Fetch ownership
  const ownership = useCallback(async () => {
    setLoading(true); // ✅ Add this
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/ownership`
      );
      const data = response?.data?.data; // Axios automatically parses JSON

      // console.log("response", data);

      if (data && Array.isArray(data)) {
        setOwnership(data);
      }
    } catch (error) {
      console.error("Error fetching ownership:", error);
      // setFetchError("Failed to fetch ownership.");
    } finally {
      setLoading(false);
    }
  }, []);

  // Fetch service-category
  const ownershipCategory = useCallback(async (ownershipId: string) => {
    setLoading(true); // ✅ Add this
    try {
      setOwnershipCategories([]);
      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/ownership-type`,
        { ownership_id: ownershipId },
        { headers: { "Content-Type": "application/json" } }
      );

      const data = response?.data?.data; // Axios automatically parses JSON

      console.log("response ownershipCategory", data);

      if (data && Array.isArray(data)) {
        setOwnershipCategories(data);
      }
    } catch (error) {
      console.error("Error fetching operational:", error);
      // setFetchError("Failed to fetch operational.");
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    if (selectedownership) {
      ownershipCategory(selectedownership);
    }
  }, [selectedownership, ownershipCategory]); // Runs when `selectedLga` changes

  // Fetch operational
  const operational = useCallback(async () => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/operational-status`
      );
      const data = response?.data?.data; // Axios automatically parses JSON

      // console.log("response", data);

      if (data && Array.isArray(data)) {
        setOperational(data);
      }
    } catch (error) {
      console.error("Error fetching operational:", error);
      // setFetchError("Failed to fetch operational.");
    } finally {
      setLoading(false);
    }
  }, []);

  // Fetch registration status
  const registrationStatus = useCallback(async () => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/registration-status`
      );
      const data = response?.data?.data; // Axios automatically parses JSON

      // console.log("response", data);

      if (data && Array.isArray(data)) {
        setRegistration(data);
      }
    } catch (error) {
      console.error("Error fetching operational:", error);
      // setFetchError("Failed to fetch operational.");
    } finally {
      setLoading(false);
    }
  }, []);

  // Fetch license status
  const license = useCallback(async () => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/license-status`
      );
      const data = response?.data?.data; // Axios automatically parses JSON

      // console.log("response", data);

      if (data && Array.isArray(data)) {
        setLicense(data);
      }
    } catch (error) {
      console.error("Error fetching operational:", error);
      // setFetchError("Failed to fetch operational.");
    } finally {
      setLoading(false);
    }
  }, []);

  // Fetch service-category
  const serviceCategory = useCallback(async () => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/service-category`
      );
      const data = response?.data?.data; // Axios automatically parses JSON

      // console.log("response", data);

      if (data && Array.isArray(data)) {
        setServiceCategory(data);
      }
    } catch (error) {
      console.error("Error fetching operational:", error);
      // setFetchError("Failed to fetch operational.");
    } finally {
      setLoading(false);
    }
  }, []);

  const fetchService = useCallback(async (serviceId: string) => {
    try {
      setService([]); // Reset LGAs
      setSelectedService(""); // Reset selected LGA

      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/services-by-category`,
        { service_category_id: serviceId },
        { headers: { "Content-Type": "application/json" } }
      );

      const data = response?.data?.data;

      if (data && Array.isArray(data)) {
        setService(data);
      }
    } catch (error) {
      console.error("Error fetching LGAs:", error);
      // setFetchError("Failed to fetch LGAs.");
    }
  }, []);

  // Fetch static data (only on mount)
  useEffect(() => {
    fetchStates();
    facilityLevel();
    ownership();
    operational();
    registrationStatus();
    license();
    serviceCategory();
  }, [
    fetchStates,
    facilityLevel,
    ownership,
    operational,
    registrationStatus,
    license,
    serviceCategory,
  ]); // Runs only once when the component mounts

  // Fetch LGAs when `states` change
  useEffect(() => {
    if (selectedState) {
      fetchLgas(selectedState);
    }
  }, [selectedState, fetchLgas]); // Runs when `selectedState` changes

  // Fetch Wards when `lgas` change
  useEffect(() => {
    if (selectedLga) {
      fetchWards(selectedLga);
    }
  }, [selectedLga, fetchWards]); // Runs when `selectedLga` changes

  // Fetch paginated facilities when `currentPage` changes
  useEffect(() => {
    fetchFacilities();
    return () => {
      // Cleanup: clear localStorage after fetch if needed
      localStorage.removeItem("entriesPerPage");
    };
    // if (currentPage) {
    // }
  }, [currentPage, fetchFacilities, entriesPerPage]); // Runs when `currentPage` changes

  const handleReset = useCallback(() => {
    setSelectedState("");
    setSelectedLga("");
    setSelectedWard("");
    setSelectedFacilityLevel("");
    setSelectedownership("");
    setSelectedOperational("");
    setSelectedRegistration("");
    setSelectedLicense("");
    setSelectedServiceCategory("");
    setSelectedService("");
    setSelectedGeoCode("");
    setSelectedServiceType("");
    setSearch("");
    setSelectedOwnershipCategory("");
    // setEntriesPerPage(50); // Reset to default 50 entries per page
    // setCurrentPage(1); // Reset to first page

    const defaultValue = entryPerPage[0].id; // Default to the first entry (25)
    setEntriesPerPage(parseInt(defaultValue, 10)); // Update state
    localStorage.setItem("entriesPerPage", defaultValue); // Update localStorage
    setCurrentPage(1); // Reset current page to 1 when entries per page change
  }, [
    // currentPage,
    setSelectedState,
    setSelectedLga,
    setSelectedWard,
    setSelectedFacilityLevel,
    setSelectedownership,
    setSelectedOperational,
    setSelectedRegistration,
    setSelectedLicense,
    setSelectedServiceCategory,
    setSelectedService,
    setSelectedGeoCode,
    setSelectedServiceType,
    setSearch,
    setSelectedOwnershipCategory,
    entryPerPage,
  ]);

  const handleSelectChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const value = parseInt(e.target.value);
    localStorage.setItem("entriesPerPage", String(value));
    setEntriesPerPage(value);
    setCurrentPage(1);
  };

  const handlePageChange = (page: number) => {
    console.log("Page changed:", page);
    setCurrentPage(page);
  };

  return (
    <div>
      <Text className="text-2xl pt-5 pb-5">Hospitals and Clinics</Text>

      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 w-full">
        {/* State Selection */}
        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedState}
          onChange={(e) => {
            const selectedId = e.target.value; // Get the state ID
            setSelectedState(selectedId);
            setSelectedLga("");
            setSelectedWard("");
            fetchLgas(selectedId);
          }}
          options={states.map((state) => ({
            value: state.id, // Ensure value is the ID
            name: state.name, // Display name
          }))}
          placeholder="All State"
        />

        {/* lga Selection */}
        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedLga}
          onChange={(e) => {
            const lgaId = e.target.value;
            setSelectedLga(lgaId);
            setSelectedWard("");
            fetchWards(lgaId); // Fetch Wards for selected LGA
          }}
          options={lgas.map((lga) => ({
            value: lga.id, // Use LGA ID
            name: lga.name, // Show LGA name
          }))}
          placeholder="Select LGA"
          disabled={!selectedState} // Disable until State is selected
        />

        {/* ward Selection */}
        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedWard}
          onChange={(e) => {
            setSelectedWard(e.target.value); // Store selected Ward
          }}
          options={wards.map((ward) => ({
            value: ward.id, // Use Ward ID
            name: ward.name, // Show Ward name
          }))}
          placeholder="Select Ward"
          disabled={!selectedLga} // Disable until LGA is selected
        />

        {/* facility level Selection */}
        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedFacilityLevel} // Track selected value
          onChange={(e) => {
            setSelectedFacilityLevel(e.target.value); // Update state
          }}
          options={facilityLevels.map((level) => ({
            value: level.id, // Use level ID
            name: level.name, // Show level name
          }))}
          placeholder="Select Facility Level"
        />

        {/* Ownership Selection */}
        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedownership} // Track selected value
          // onChange={(e) => {
          //   const ownershipId = e.target.value;
          //   setSelectedownership(ownershipId);
          //   ownershipCategory(ownershipId); // Fetch Wards for selected LGA
          // }}
          onChange={(e) => {
            const ownershipId = e.target.value;
            setSelectedownership(ownershipId); // Update selected ownership
            setSelectedOwnershipCategory(""); // Clear ownership type selection when ownership is changed
            ownershipCategory(ownershipId); // Fetch related ownership categories for the selected ownership
          }}
          options={ownerships.map((item) => ({
            value: item.id, // Use items ID
            name: item.name, // Show items name
          }))}
          placeholder="Select Ownership"
        />

        {/* Show Ownership Category Dropdown Only When Ownership is Selected */}
        {selectedownership && (
          <SelectComponent
            className="w-full max-w-[350px]"
            value={selectedOwnershipCategory}
            onChange={(e) => setSelectedOwnershipCategory(e.target.value)}
            options={ownershipCategories.map((item) => ({
              value: item.id, // Map `id` to `value`
              name: item.type,
            }))}
            placeholder="Select Ownership Type"
          />
        )}

        {/* operational Selection */}
        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedOperational} // Track selected value
          onChange={(e) => {
            setSelectedOperational(e.target.value); // Update state
          }}
          options={operationals.map((items) => ({
            value: items.id, // Use items ID
            name: items.status, // Show items name
          }))}
          placeholder="Select Operational"
        />

        {/* Registration status Selection */}
        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedRegistration} // Track selected value
          onChange={(e) => {
            setSelectedRegistration(e.target.value); // Update state
          }}
          options={registrations.map((items) => ({
            value: items.id, // Use items ID
            name: items.status, // Show items name
          }))}
          placeholder="Select Registration status"
        />

        {/* licenses */}
        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedLicense} // Track selected value
          onChange={(e) => {
            setSelectedLicense(e.target.value); // Update state
          }}
          options={licenses.map((items) => ({
            value: items.id, // Use items ID
            name: items.status, // Show items name
          }))}
          placeholder="Select License status"
        />

        {/* Select Coordinates */}
        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedGeoCode} // Track selected value
          onChange={(e) => {
            setSelectedGeoCode(e.target.value); // Update state
          }}
          options={[
            { value: "0", name: "Select Coordinates" },
            { value: "1", name: "With Coordinates" },
            { value: "2", name: "With No Coordinates" },
          ]}
          // placeholder="Select Coordinates"
        />

        {/* Select Service Type */}
        {/* <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedServiceType} // Track selected value
          onChange={(e) => {
            setSelectedServiceType(e.target.value); // Update state
          }}
          options={[
            { value: "0", name: "Select Service Type" },
            { value: "1", name: "Out Patient" },
            { value: "2", name: "In Patient" },
          ]}
          placeholder="Select Service Type"
        /> */}

        {/* Select Service type */}

        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedServiceCategory}
          onChange={(e) => {
            const serviceId = e.target.value; // Get the state ID
            setSelectedServiceCategory(serviceId);
            fetchService(serviceId);
          }}
          options={serviceCategories.map((items) => ({
            value: items.id, // Use items ID
            name: items.description, // Show items name
          }))}
          placeholder="Select Service Category"
        />

        <SelectComponent
          className="w-full max-w-[350px]"
          value={selectedService}
          onChange={(e) => {
            setSelectedService(e.target.value);
          }}
          options={services.map((item) => ({
            value: item.id, // Use item ID
            name: item.name, // Show item name
          }))}
          placeholder="Select Service"
          disabled={!selectedState} // Disable until State is selected
        />
      </div>

      <div className="flex flex-wrap items-center justify-center gap-4 bg-[#D1D1D1] p-4 mt-4 w-full md:grid md:grid-cols-2 lg:flex lg:gap-6">
        {/* Facility Name Input */}
        {/* <Input
          ref={searchInputRef}
          className="w-full max-w-[400px] h-[55px] text-sm"
          placeholder="Facility Name"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        /> */}

        {/* Facility Name Input */}
        <Input
          className="w-full max-w-[400px] h-[47px] text-sm"
          placeholder="Facility Name"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />

        {/* Entries Per Page Dropdown */}
        {/* <SelectComponent
          className="w-full max-w-[300px] h-[44px] text-sm"
          placeholder="Entries Per Page"
        /> */}

        {/* Entries Per Page Dropdown */}
        <SelectComponent3
          className="w-full max-w-[300px] h-[44px] text-sm"
          placeholder="Entries Per Page"
          options={entryPerPage.map((item) => ({
            value: item.id, // Use item ID
            name: item.name, // Show item name
          }))}
          value={String(entriesPerPage)} // Convert number to string for select compatibility
          onChange={handleSelectChange} // Correct conversion to number
        />

        {/* Reset Button */}
        <button
          className="bg-[#EFEFEF] rounded-lg w-full max-w-[200px] h-[44px] flex items-center justify-center text-sm"
          onClick={handleReset}
        >
          Reset
        </button>

        <GreenButton
          onClick={fetchFacilities2}
          className="bg-[#5BBA62] w-full max-w-[200px] h-[44px] flex items-center justify-center text-sm"
        >
          {loading ? "Loading..." : "Search"}
        </GreenButton>
      </div>

      {/* <div className="w-full overflow-x-hidden max-w-[100vw] md:overflow-x-auto">
        <HospitalTable />
      </div> */}
      <div className="w-full overflow-x-auto lg:overflow-x-scroll xl:overflow-x-hidden">
        <div className="min-w-[700px] lg:min-w-[900px]">
          <HospitalTable
            key={`${entriesPerPage}-${currentPage}`} // force re-render
            data={data}
            currentPage={currentPage}
            setCurrentPage={setCurrentPage}
            totalPages={totalPages}
            totalRecords={totalRecords}
            // fetchFacilities={fetchFacilities} // Pass function to child
            entriesPerPage={entriesPerPage} // Pass entriesPerPage to child component
          />
        </div>
      </div>
    </div>
  );
};

export default HospitalTab;
