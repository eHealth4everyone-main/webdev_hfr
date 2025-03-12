"use client"; // Ensure this is the first line

import React, { useCallback, useEffect, useState } from "react";
import { GreenButton, Text } from "../ui/Typography";
import Input from "../ui/Input";
import SelectComponent from "../ui/SelectComponent";
import SelectComponent2 from "../ui/SelectComponent2";
import axios from "axios";

// import { useRouter } from "next/router"; // Import Next.js Router
import { useRouter } from "next/navigation";

const Overlay = () => {
  const [isClient, setIsClient] = useState(false);
  const router = useRouter();

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

  const handleSearch = async () => {
    setLoading(true);

    const searchValues = {
      search: search || "",
      facilityType: selectedFacilityType || "",
      facilityLevel: selectedFacilityLevel || "",
    };

    try {
      // Fetch the facilities from the backend
      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facilities-hospitals-search2`,
        {
          facility_level_id: searchValues.facilityLevel,
          facility_type_id: searchValues.facilityType,
          facility_name: searchValues.search,
        }
      );

      const facilities = response.data?.data?.facilities?.data || [];

      // Store search results and parameters in localStorage BEFORE navigating
      localStorage.setItem("searchResults", JSON.stringify(facilities));
      localStorage.setItem("searchParams", JSON.stringify(searchValues));

      // Now, navigate to FacilityFinder page
      const queryParams = new URLSearchParams(searchValues).toString();
      router.push(`/facilityfinder?${queryParams}`);
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
        <Input
          className="mt-[-.3rem]"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          placeholder="Input your location"
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
          Search
        </GreenButton>
      </div>
    </div>
  );
};

export default Overlay;
