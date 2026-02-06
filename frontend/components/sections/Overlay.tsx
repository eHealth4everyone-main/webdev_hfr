"use client"; // Ensure this is the first line

import React, { useCallback, useEffect, useState } from "react";
import { GreenButton, Text } from "../ui/Typography";
import Input from "../ui/Input";
import SelectComponent from "../ui/SelectComponent";
import SelectComponent2 from "../ui/SelectComponent2";
import axios from "axios";

// import { useRouter } from "next/router"; // Import Next.js Router
import { usePathname, useRouter } from "next/navigation";

import { format } from "url";
import Link from "next/link";

interface Facility {
  id: number;
  facility_name: string;
  alt_facility_name?: string | null;
  latitude: number | null;
  longitude: number | null;
  state_id?: number;
  state_name?: string;
  lga_id?: number;
  lga_name?: string;
  ward_id?: number;
  ward_name?: string;
  ownership_id?: number;
  ownership_name?: string;
  ownership_type_id?: string | null;
  facility_level_id?: number;
  facility_level_name?: string;
  facility_level_option_id?: number | null;
  facility_level_options_category_id?: number | null;
  license_status_id?: number;
  license_status_name?: string;
  registration_status_id?: number;
  registration_status_name?: string;
  operational_status_id?: number;
  operational_status_name?: string;
  phone_number?: string;
  email_address?: string;
  website?: string | null;
  physical_location?: string | null;
  postal_address?: string | null;
  beds?: number | null;
  doctors?: number | null;
  nurses?: number | null;
  midwifes?: number | null;
  lab_scientists?: number | null;
  lab_technicians?: number | null;
  pharmacists?: number | null;
  pharmacy_technicians?: number | null;
  him_officers?: number | null;
  env_health_officers?: number | null;
  dental_technicians?: number | null;
  dentist?: number | null;
  attendants?: number | null;
  community_health_officer?: number | null;
  community_extension_workers?: number | null;
  jun_community_extension_worker?: number | null;
  inpatient?: string | null;
  outpatient?: string | null;
  ambulance_services?: string;
  onsite_laboratory?: string | null;
  onsite_imaging?: string | null;
  onsite_pharmarcy?: string | null;
  mortuary_services?: string | null;
  operational_days?: string | null;
  operational_hours?: string | null;
  image_url?: string | null;
  start_date?: string | null;
  close_date?: string | null;
  unique_id?: string;
  registration_no?: string | null;
  publish_note?: string | null;
  published_at?: string | null;
  published_by?: string | null;
  request_note?: string | null;
  requested_at?: string | null;
  requested_by?: string | null;
  validate_note?: string | null;
  validated_at?: string | null;
  validated_by?: string | null;
  verify_note?: string | null;
  verified_at?: string | null;
  verified_by?: string | null;
  status_id?: number;
  created_at?: string;
  updated_at?: string;
  created_by?: string | null;
}

const Overlay = () => {
  const [isClient, setIsClient] = useState(false);
  const router = useRouter();
  const pathname = usePathname();

  const [facilityTypes, setFacilityTypes] = useState<any[]>([]);
  const [facilityLevels, setFacilityLevel] = useState<any[]>([]);

  const [loading, setLoading] = useState<boolean>(true); // State for loading state
  const [fetchError, setFetchError] = useState<string>(""); // State for error

  const [search, setSearch] = useState("");
  const [selectedFacilityLevel, setSelectedFacilityLevel] = useState("");
  const [selectedFacilityType, setSelectedFacilityType] = useState("");
  const [hospitals, setHospitals] = useState<any[]>([]);
  const [totalPages, setTotalPages] = useState(1); // Store total pages

  // Fetch data from the API
  const fetchFacilityTypes = useCallback(async () => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facility-type`
      );

      const data = response?.data?.data; // Axios automatically parses JSON
      console.log("data", data);

      if (data && Array.isArray(data)) {
        setFacilityTypes(data); // Set the options from the fetched data
      }
    } catch (error) {
      setFetchError("Failed to fetch facility types.");
    } finally {
      setLoading(false);
    }
  }, []);

  const fetchFacilityLevels = useCallback(async () => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facility-level`
      );

      const data = response?.data?.data; // Axios automatically parses JSON
      // console.log("data", data);

      if (data && Array.isArray(data)) {
        setFacilityLevel(data); // Set the options from the fetched data
      }
    } catch (error) {
      setFetchError("Failed to fetch facility types.");
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    fetchFacilityTypes(); // Call the function to fetch data
    fetchFacilityLevels(); // Call the function to fetch data
  }, [fetchFacilityTypes, fetchFacilityLevels]); // Empty dependency array ensures it runs only once on component mount

  const handleSearchOLDPOST = async () => {
    setLoading(true);

    const searchValues = {
      search: search || "",
      facilityType: selectedFacilityType || "",
      facilityLevel: selectedFacilityLevel || "",
    };

    try {
      // Fetch the facilities from the backend
      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facilities-hospitals-search3`,
        {
          facility_level_id: searchValues.facilityLevel,
          facility_type_id: searchValues.facilityType,
          facility_name: searchValues.search,
        }
      );

      // const facilities = response.data?.data?.facilities?.data || [];
      const facilities = response.data?.data?.facilities || [];

      // Store search results and parameters in localStorage BEFORE navigating
      // localStorage.setItem("searchResults", JSON.stringify(facilities));
      // Always store result — either actual data or empty array
      localStorage.setItem(
        "searchResults",
        JSON.stringify(Array.isArray(facilities) ? facilities : [])
      );

      // localStorage.setItem("searchParams", JSON.stringify(searchValues));

      // Now, navigate to FacilityFinder page
      // const queryParams = new URLSearchParams(searchValues).toString();
      router.push("/facilityfinder"); // Navigate without query parameters
    } catch (error) {
      console.error("Error fetching data:", error);
    } finally {
      setLoading(false);
    }
  };

  const handleSearch = async () => {
    setLoading(true);

    const searchValues = {
      search: search || "",
      facilityType: selectedFacilityType || "",
      facilityLevel: selectedFacilityLevel || "",
    };

    const params: any = {};

    // If there are search values, append them as query parameters
    if (searchValues.facilityLevel) {
      params.facility_level_id = searchValues.facilityLevel;
    }
    if (searchValues.facilityType) {
      params.facility_type_id = searchValues.facilityType;
    }
    if (searchValues.search) {
      params.facility_name = searchValues.search;
    }

    const query = {
      facilityLevel: selectedFacilityLevel || "",
      facilityType: selectedFacilityType || "",
      search: search || "",
    };

    try {
      // Fetch the facilities from the backend
      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facilities-hospitals-search3`,
        {
          facility_level_id: searchValues.facilityLevel,
          facility_type_id: searchValues.facilityType,
          facility_name: searchValues.search,
        }
      );

      const facilities = response.data?.data?.facilities?.data || [];
      // const facilities = response.data?.data?.facilities || [];

      // Store search results and parameters in localStorage BEFORE navigating
      // localStorage.setItem("searchResults", JSON.stringify(facilities));
      // Always store result — either actual data or empty array
      localStorage.setItem(
        "searchResults",
        JSON.stringify(Array.isArray(facilities) ? facilities : [])
      );

      localStorage.setItem("homePageSearchQuery", JSON.stringify(query));
      // return;

      // Now, navigate to FacilityFinder page
      // const queryParams = new URLSearchParams(searchValues).toString();

      // 🟢 Update browser URL with query parameters
      router.push(format({ pathname: "/facilityfinder", query }));

      // router.push("/facilityfinder"); // Navigate without query parameters
    } catch (error) {
      console.error("Error fetching data:", error);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="w-full bg-[#F5F7FA] mx-auto lg:w-[1200px] rounded-lg md:h-[268px] mt-[-7rem] z-50 pt-[1rem] flex flex-col justify-center items-center">
      <Text className="font-[600] text-center mt-3 md:mt-0">
        Facility <span className="text-[#5CB85C]">Finder</span>
      </Text>

      <Text className="font-[400] text-center p-2 md:p-0">
        Search for Health Facilities Close To You
      </Text>
      <div className="grid grid-cols-1 md:grid-cols-2 md:justify-items-center lg:flex lg:flex-row mx-[1rem] lg:mx-[0] justify-center items-center gap-[1rem] mt-[1rem]">
        <input
          // className="mt-[-.2rem]"
          className="w-full mt-[-0.2rem] p-3 border border-gray-300 rounded placeholder-gray-400"
          placeholder="Enter Location/Facility Name"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />

        <SelectComponent
          options={facilityTypes?.map((type) => ({
            value: type.id, // Use type ID
            name: type.name, // Show type name
          }))}
          value={selectedFacilityType}
          onChange={(e) => setSelectedFacilityType(e.target.value)}
          error={fetchError}
          placeholder="Select Facility Type"
        />

        <SelectComponent
          value={selectedFacilityLevel}
          onChange={(e) => setSelectedFacilityLevel(e.target.value)}
          options={facilityLevels.map((level) => ({
            value: level.id, // Use level ID
            name: level.name, // Show level name
          }))}
          error={fetchError}
          placeholder="Select Facility Level"
        />
        <GreenButton onClick={handleSearch} className="w-[250px] p-3">
          {loading ? "Loading..." : "Search"}
        </GreenButton>
      </div>
    </div>
  );
};

export default Overlay;
