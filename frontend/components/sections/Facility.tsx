"use client";

import { Button, Card } from "@chakra-ui/react";
import { CiSliderHorizontal } from "react-icons/ci";
import { MdLocationPin } from "react-icons/md";
import { IoCopy } from "react-icons/io5";
import Input from "../ui/Input";
import SelectComponent from "../ui/SelectComponent";
import { GreenButton, Text, WhiteButton } from "../ui/Typography";

import React, { useState, useRef, useCallback, useEffect } from "react";
import {
  LoadScript,
  GoogleMap,
  Marker,
  InfoWindow,
  DirectionsRenderer,
  DirectionsService,
} from "@react-google-maps/api";
import {
  MapPin,
  Search,
  SlidersHorizontal,
  LayoutDashboard,
  Menu,
  Copy,
} from "lucide-react";

import Image from "next/image";
import axios from "axios";

import { useRouter } from "next/navigation";

// import { useRouter } from "next/router";

const libraries: "places"[] = ["places"];

function Facility() {
  const { push } = useRouter();
  const router = useRouter();

  const [map, setMap] = useState<google.maps.Map | null>(null);

  const [searchBox, setSearchBox] =
    useState<google.maps.places.SearchBox | null>(null);

  const [hospitals, setHospitals] = useState<any[]>([]);

  const [selectedHospital, setSelectedHospital] = useState<any | null>(null);

  const [center, setCenter] = useState({ lat: 9.0765, lng: 7.3986 }); // Abuja coordinates
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const searchInputRef = useRef<HTMLInputElement>(null);

  const [facilityTypes, setFacilityTypes] = useState<
    { id: string; name: string }[]
  >([]);

  const [facilityLevels, setFacilityLevel] = useState<any[]>([]);

  const [fetchError, setFetchError] = useState<string>(""); // State for error

  const [selectedFacilityLevel, setSelectedFacilityLevel] = useState("");
  const [selectedFacilityType, setSelectedFacilityType] = useState("");
  const [searchQuery, setSearchQuery] = useState("");

  const [data, setData] = useState([]); // Store API response
  const [currentPage, setCurrentPage] = useState(1); // Track pagination
  const [totalPages, setTotalPages] = useState(1); // Store total pages

  const [search, setSearch] = useState("");

  // const [directions, setDirections] = useState(null);
  // const [directions, setDirections] = useState<null>(null);
  const [directions, setDirections] =
    useState<google.maps.DirectionsResult | null>(null);

  const [directionsRenderer, setDirectionsRenderer] = useState(null);

  const [directionsService, setDirectionsService] =
    useState<google.maps.DirectionsService | null>(null);
  const [userLocation, setUserLocation] =
    useState<google.maps.LatLngLiteral | null>(null);

  // Initialize Google Directions Service
  const onMapLoad = (map: any) => {
    setMap(map);
    // setDirectionsService(new window.google.maps.DirectionsService());
    setDirectionsService(() => new window.google.maps.DirectionsService());
  };

  useEffect(() => {
    if (selectedHospital) {
      setCenter({
        lat: selectedHospital.latitude,
        lng: selectedHospital.longitude,
      });

      // Request directions from current location to selected hospital
      const directionsService = new window.google.maps.DirectionsService();

      if (!userLocation) {
        console.error("User location is not available.");
        return; // Exit the function early
      }

      directionsService.route(
        {
          origin: userLocation, // User's location
          destination: {
            lat: selectedHospital.latitude,
            lng: selectedHospital.longitude,
          },
          travelMode: window.google.maps.TravelMode.DRIVING,
        },
        (result, status) => {
          if (status === window.google.maps.DirectionsStatus.OK) {
            if (result) {
              setDirections(result);
            }
            // setDirections(result);
          } else {
            console.error("Error fetching directions", status);
          }
        }
      );
    }
  }, [selectedHospital, userLocation]);

  // Function to handle clicking "View Direction"
  useEffect(() => {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        setUserLocation({
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        });
        console.log(
          "User Location Set:",
          position.coords.latitude,
          position.coords.longitude
        );
      },
      (error) => console.error("Error getting location:", error),
      { enableHighAccuracy: true }
    );
  }, []);

  const handleGetDirections = (hospital: any) => {
    if (!userLocation) {
      console.error("User location not available yet.");
      return;
    }

    if (!hospital || !hospital.latitude || !hospital.longitude) {
      console.error("Invalid hospital data:", hospital);
      return;
    }

    const destination = {
      lat: parseFloat(hospital.latitude),
      lng: parseFloat(hospital.longitude),
    };

    if (isNaN(destination.lat) || isNaN(destination.lng)) {
      console.error("Invalid coordinates for hospital:", hospital);
      return;
    }

    // console.log("Getting directions from:", userLocation, "to:", destination);

    const directionsService = new google.maps.DirectionsService();

    directionsService.route(
      {
        origin: userLocation, // Use current location
        destination, // Use parsed coordinates
        travelMode: google.maps.TravelMode.DRIVING,
      },
      (result, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
          setDirections(result);
          setCenter(destination); // Center map on selected hospital
        } else {
          console.error("Directions request failed:", status);
        }
      }
    );
  };

  const fetchFacilitiesOLD = useCallback(async () => {
    setLoading(true);
    setFetchError("");
    try {
      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facilities-hospitals-search2`,
        {
          facility_level_id: selectedFacilityLevel,
          facility_type_id: selectedFacilityType,
          facility_name: searchQuery,
          search,
        }
      );

      // console.log("record", response.data?.data?.facilities?.data);

      // setData(response.data?.data?.facilities?.data);
      setHospitals(response.data?.data?.facilities?.data);
      setTotalPages(response.data?.data?.facilities?.last_page);
    } catch (error) {
      console.error("Error fetching data:", error);
    } finally {
      setLoading(false);
    }
  }, [selectedFacilityLevel, selectedFacilityType, searchQuery, search]);

  const fetchFacilities = async (searchValues: {
    facilityLevel?: string;
    facilityType?: string;
    search?: string;
  }) => {
    setLoading(true);
    setFetchError("");

    try {
      const response = await axios.post(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facilities-hospitals-search2`,
        {
          facility_level_id: searchValues.facilityLevel,
          facility_type_id: searchValues.facilityType,
          facility_name: searchValues.search,
        }
      );

      setHospitals(response.data?.data?.facilities?.data);
      setTotalPages(response.data?.data?.facilities?.last_page);
    } catch (error) {
      console.error("Error fetching data:", error);
    } finally {
      setLoading(false);
    }
  };

  // Fetch data from the API
  const fetchFacilityTypes = useCallback(async () => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facility-type`
      );

      const data = response?.data?.data;
      console.log("fetchFacilityTypes data", data);

      if (data && Array.isArray(data)) {
        setFacilityTypes(data);
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

      console.log("fetchFacilityLevels data", data);
    } catch (error) {
      setFetchError("Failed to fetch facility types.");
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    fetchFacilityTypes();
    fetchFacilityLevels();
  }, [fetchFacilityTypes, fetchFacilityLevels]);

  useEffect(() => {
    // console.log("Hospitals state updated:", hospitals);
  }, [hospitals]);

  const handleSearch = () => {
    setLoading(true);

    // Call fetchFacilities with selected values
    fetchFacilities({
      search,
      facilityType: selectedFacilityType,
      facilityLevel: selectedFacilityLevel,
    });

    setLoading(false);
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="container mx-auto p-4">
        <div className="bg-white rounded-lg shadow-sm p-6">
          <h1 className="text-lg font-medium text-gray-800 mb-6">
            Search based on location
          </h1>

          <div className="space-y-4">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
              {/* 🔍 Search Location */}
              <div className="relative lg:col-span-2">
                <input
                  ref={searchInputRef}
                  type="text"
                  placeholder="Enter location"
                  value={search}
                  onChange={(e) => setSearch(e.target.value)}
                  className="w-full p-3 pr-10 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                />
                {/* <Search className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400" /> */}
              </div>

              {/* 🏥 Facility Type */}
              <select
                value={selectedFacilityType}
                onChange={(e) => setSelectedFacilityType(e.target.value)}
                className="p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
              >
                <option value="">Select Facility Type</option>
                {facilityTypes?.map((type) => (
                  <option key={type.id} value={type.id}>
                    {type.name}
                  </option>
                ))}
              </select>

              {/* 📊 Facility Level */}
              <select
                value={selectedFacilityLevel}
                onChange={(e) => setSelectedFacilityLevel(e.target.value)}
                className="p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
              >
                <option value="">Select Facility Level</option>
                {facilityLevels?.map((level) => (
                  <option key={level.id} value={level.id}>
                    {level.name}
                  </option>
                ))}
              </select>

              <GreenButton
                onClick={handleSearch}
                className="w-full max-w-[200px] h-[44px] flex items-center justify-center text-sm"
              >
                {loading ? "Loading..." : "Search Location"}
              </GreenButton>

              <button className="flex items-center justify-center gap-2 p-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                <SlidersHorizontal size={20} />
                <span>More filters</span>
              </button>
            </div>

            <div className="flex justify-between items-center bg-green-50 p-4 rounded-lg">
              <p className="text-gray-700">
                {hospitals.length} healthcare facilities found in your area
              </p>
              <div className="flex gap-1">
                <button className="p-2 bg-gray-900 text-white rounded-lg">
                  <Menu size={20} />
                </button>
                <button className="p-2 bg-white text-gray-900 rounded-lg">
                  <LayoutDashboard size={20} />
                </button>
              </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <div className={`flex-1`}>
                {hospitals.slice(0, 2).map((hospital) => {
                  const imageUrl =
                    Array.isArray(hospital.image_url) &&
                    hospital.image_url.length > 0
                      ? hospital.image_url[0]
                      : "/gh1.svg";

                  return (
                    <Card key={hospital.id} className="mb-4 p-8">
                      {/* Responsive Grid: Image on top for small screens, side-by-side for large screens */}
                      <div className="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                        {/* Hospital Image - Takes full width on small screens, half width on larger screens */}
                        <div className="w-full h-[250px] flex items-center">
                          <Image
                            src={imageUrl}
                            width={250}
                            height={150}
                            alt={hospital.facility_name ?? "N/A"}
                            className="object-cover w-full h-full rounded-lg"
                          />
                        </div>

                        {/* Hospital Details - Below image on small screens, beside it on large screens */}
                        <div className="flex flex-col gap-4">
                          <h2 className="text-lg font-semibold">
                            {hospital.facility_name ?? "N/A"}
                          </h2>
                          <p className="text-sm text-gray-600">
                            {hospital.address ?? "N/A"}
                          </p>
                          <p className="text-sm text-gray-600">
                            Contact info: {hospital.phone_number ?? "N/A"}
                          </p>
                          <p className="text-sm text-gray-600">
                            Plans accepted: Exclusive Provider Organization
                            (EPO), HMO, Medi-Cal Managed Care, Point-of-Service
                            Plan (POS), Senior Advantage
                          </p>

                          {/* Buttons */}
                          <div className="flex space-x-4">
                            <a
                              href="javascript:void(0)"
                              rel="noopener noreferrer"
                              type="button"
                              className="text-green-600 font-semibold text-center"
                              onClick={() => handleGetDirections(hospital)}
                            >
                              View Direction
                            </a>

                            <a
                              href="javascript:void(0)"
                              rel="noopener noreferrer"
                              type="button"
                              className="text-green-600 font-semibold text-center"
                              onClick={(e) => {
                                e.preventDefault(); // Prevent full page reload
                                router.push(
                                  `/facilityfinder/details/${hospital.id}`
                                );
                              }}

                              // onClick={(e) => {
                              //   e.preventDefault();
                              //   handleViewDetails(hospital);
                              // }}
                            >
                              View Details
                            </a>
                          </div>
                        </div>
                      </div>
                    </Card>
                  );
                })}
              </div>

              <div className="h-[600px] rounded-lg overflow-hidden">
                <LoadScript
                  googleMapsApiKey={
                    process.env.NEXT_PUBLIC_GOOGLE_MAP_API ?? ""
                  }
                  libraries={libraries}
                >
                  <GoogleMap
                    mapContainerClassName="w-full h-full"
                    center={center}
                    zoom={15}
                  >
                    {/* User's Location Marker */}
                    {/* <Marker position={userLocation} label="You" /> */}
                    {userLocation && (
                      <Marker position={userLocation} label="You" />
                    )}

                    {/* Selected Hospital Marker */}
                    {selectedHospital && (
                      <Marker
                        key={selectedHospital.id}
                        position={{
                          lat: selectedHospital.latitude,
                          lng: selectedHospital.longitude,
                        }}
                        onClick={() => setSelectedHospital(selectedHospital)}
                      />
                    )}

                    {/* Route Line */}
                    {directions && (
                      <DirectionsRenderer directions={directions} />
                    )}

                    {/* InfoWindow for Selected Hospital */}
                    {selectedHospital && (
                      <InfoWindow
                        position={{
                          lat: selectedHospital.latitude,
                          lng: selectedHospital.longitude,
                        }}
                        onCloseClick={() => setSelectedHospital(null)}
                      >
                        <div className="p-2">
                          <h3 className="font-bold mb-2">
                            {selectedHospital.facility_name}
                          </h3>
                          <p className="text-sm mb-1">
                            {selectedHospital.address}
                          </p>
                          {selectedHospital.phone_number && (
                            <p className="text-sm text-blue-600">
                              {selectedHospital.phone_number}
                            </p>
                          )}
                        </div>
                      </InfoWindow>
                    )}
                  </GoogleMap>
                </LoadScript>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Facility;
