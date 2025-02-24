"use client";
import { Button, Card } from "@chakra-ui/react";
import { CiSliderHorizontal } from "react-icons/ci";
import { MdLocationPin } from "react-icons/md";
import { IoCopy } from "react-icons/io5";
import { useRouter } from "next/navigation";
import Input from "../ui/Input";
import SelectComponent from "../ui/SelectComponent";
import { GreenButton, Text, WhiteButton } from "../ui/Typography";

import React, { useState, useRef, useCallback, useEffect } from "react";
import {
  LoadScript,
  GoogleMap,
  Marker,
  InfoWindow,
} from "@react-google-maps/api";
import {
  MapPin,
  Search,
  SlidersHorizontal,
  LayoutDashboard,
  Menu,
  Copy,
} from "lucide-react";

const libraries: "places"[] = ["places"];

type Hospital = {
  id: string;
  name: string;
  address: string;
  lat: number;
  lng: number;
  rating?: number;
  openNow?: boolean;
  photoUrl?: string;
  phoneNumber?: string;
  facilityType?: string;
  plansAccepted?: string[];
};

function Facility() {
  const [map, setMap] = useState<google.maps.Map | null>(null);
  const [searchBox, setSearchBox] =
    useState<google.maps.places.SearchBox | null>(null);
  const [hospitals, setHospitals] = useState<Hospital[]>([]);
  const [selectedHospital, setSelectedHospital] = useState<Hospital | null>(
    null
  );
  const [center, setCenter] = useState({ lat: 9.0765, lng: 7.3986 }); // Abuja coordinates
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const searchInputRef = useRef<HTMLInputElement>(null);

  useEffect(() => {
    console.log("Hospitals state updated:", hospitals);
  }, [hospitals]);

  const onMapLoad = useCallback((map: google.maps.Map) => {
    setMap(map);
    if (searchInputRef.current) {
      const searchBox = new google.maps.places.SearchBox(
        searchInputRef.current
      );
      setSearchBox(searchBox);
      map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds() as google.maps.LatLngBounds);
      });

      searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        if (!places || places.length === 0) return;

        const bounds = new google.maps.LatLngBounds();
        const place = places[0];

        if (!place.geometry || !place.geometry.location) return;

        const newCenter = {
          lat: place.geometry.location.lat(),
          lng: place.geometry.location.lng(),
        };
        setCenter(newCenter);
        searchNearbyHospitals(newCenter);

        if (place.geometry.viewport) {
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }

        map.fitBounds(bounds);
      });
    }
  }, []);

  const searchNearbyHospitals = useCallback(
    async (location: { lat: number; lng: number }) => {
      if (!map) return;

      setLoading(true);
      setError(null);
      setHospitals([]); // Clear existing hospitals before new search

      try {
        const service = new google.maps.places.PlacesService(map);
        const request = {
          location: new google.maps.LatLng(location.lat, location.lng),
          radius: 5000,
          type: "hospital",
        };

        service.nearbySearch(request, (results, status) => {
          if (status === google.maps.places.PlacesServiceStatus.OK && results) {
            console.log("Initial search results:", results);

            const hospitalPromises = results.map(async (place) => {
              return new Promise<Hospital>((resolve) => {
                service.getDetails(
                  {
                    placeId: place.place_id!,
                    fields: [
                      "name",
                      "formatted_address",
                      "formatted_phone_number",
                      "photos",
                      "opening_hours",
                      "rating",
                    ],
                  },
                  (details, detailStatus) => {
                    if (
                      detailStatus ===
                        google.maps.places.PlacesServiceStatus.OK &&
                      details
                    ) {
                      resolve({
                        id: place.place_id || `hospital-${Math.random()}`,
                        name: details.name || "Unknown Hospital",
                        address:
                          details.formatted_address || "Address not available",
                        lat: place.geometry?.location?.lat() || 0,
                        lng: place.geometry?.location?.lng() || 0,
                        rating: details.rating,
                        openNow: details.opening_hours?.isOpen(),
                        photoUrl: details.photos?.[0]?.getUrl({
                          maxWidth: 300,
                          maxHeight: 200,
                        }),
                        phoneNumber: details.formatted_phone_number,
                        facilityType: "Primary Health Care (PHC)",
                        plansAccepted: [
                          "Exclusive Provider Organization (EPO)",
                          "HMO",
                          "Medi-Cal Managed Care",
                          "Point-of-Service Plan (POS)",
                          "Senior Advantage",
                        ],
                      });
                    } else {
                      resolve({
                        id: place.place_id || `hospital-${Math.random()}`,
                        name: place.name || "Unknown Hospital",
                        address: place.vicinity || "Address not available",
                        lat: place.geometry?.location?.lat() || 0,
                        lng: place.geometry?.location?.lng() || 0,
                        rating: place.rating,
                        openNow: place.opening_hours?.isOpen(),
                        photoUrl: place.photos?.[0]?.getUrl({
                          maxWidth: 300,
                          maxHeight: 200,
                        }),
                        facilityType: "Primary Health Care (PHC)",
                        plansAccepted: [
                          "Exclusive Provider Organization (EPO)",
                          "HMO",
                          "Medi-Cal Managed Care",
                          "Point-of-Service Plan (POS)",
                          "Senior Advantage",
                        ],
                      });
                    }
                  }
                );
              });
            });

            Promise.all(hospitalPromises)
              .then((hospitalResults) => {
                console.log("Setting hospitals:", hospitalResults);
                setHospitals(hospitalResults);
              })
              .catch((error) => {
                console.error("Error resolving hospital promises:", error);
                setError("Error processing hospital data");
              })
              .finally(() => {
                setLoading(false);
              });
          } else {
            console.log("No results or error status:", status);
            setError("No hospitals found in this area");
            setLoading(false);
          }
        });
      } catch (err) {
        console.error("Search error:", err);
        setError("Error searching for hospitals");
        setLoading(false);
      }
    },
    [map]
  );

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="container mx-auto p-4">
        <div className="bg-white rounded-lg shadow-sm p-6">
          <h1 className="text-lg font-medium text-gray-800 mb-6">
            Search based on location
          </h1>

          <div className="space-y-4">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
              <div className="relative lg:col-span-2">
                <input
                  ref={searchInputRef}
                  type="text"
                  placeholder="Enter location"
                  className="w-full p-3 pr-10 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                />
                <Search className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
              </div>
              <select className="p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option>Select type</option>
              </select>
              <select className="p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option>Select category</option>
              </select>
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
              <div className="space-y-4 max-h-[600px] overflow-y-auto">
                {loading ? (
                  <div className="text-center p-4">
                    Searching for hospitals...
                  </div>
                ) : hospitals.length > 0 ? (
                  hospitals.map((hospital) => (
                    <div
                      key={hospital.id}
                      className="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow"
                      onClick={() => setSelectedHospital(hospital)}
                    >
                      <div className="flex gap-4 p-4">
                        <img
                          src={
                            hospital.photoUrl ||
                            "https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=300&h=200&fit=crop"
                          }
                          alt={hospital.name}
                          className="w-24 h-24 object-cover rounded-lg"
                        />
                        <div className="flex-1">
                          <div className="flex justify-between items-start">
                            <h3 className="font-semibold text-gray-900">
                              {hospital.name}
                            </h3>
                            <button className="text-gray-400 hover:text-gray-600">
                              <Copy size={16} />
                            </button>
                          </div>
                          <div className="flex items-start mt-1 text-gray-600 text-sm">
                            <MapPin className="w-4 h-4 mt-1 mr-2 flex-shrink-0" />
                            <p>{hospital.address}</p>
                          </div>
                          <div className="mt-2">
                            <div className="text-sm text-gray-600">
                              <span className="font-medium">Contact Info:</span>
                              <span className="ml-2">
                                {hospital.phoneNumber || "Not available"}
                              </span>
                            </div>
                            <div className="text-sm text-gray-600">
                              <span className="font-medium">
                                Facility Type:
                              </span>
                              <span className="ml-2">
                                {hospital.facilityType}
                              </span>
                            </div>
                          </div>
                          <div className="mt-2 flex flex-wrap gap-2">
                            <span
                              className={`text-sm px-2 py-1 rounded ${
                                hospital.openNow
                                  ? "bg-green-100 text-green-800"
                                  : "bg-red-100 text-red-800"
                              }`}
                            >
                              {hospital.openNow ? "Open" : "Closed"}
                            </span>
                            {hospital.rating && (
                              <span className="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                Rating: {hospital.rating} ⭐
                              </span>
                            )}
                          </div>
                        </div>
                      </div>
                      <div className="px-4 pb-4">
                        <div className="text-sm text-gray-600">
                          <span className="font-medium">Plans accepted:</span>
                          <p className="mt-1 text-gray-500">
                            {hospital.plansAccepted?.join(", ")}
                          </p>
                        </div>
                        <div className="mt-3 flex gap-2">
                          <button className="text-green-600 text-sm hover:text-green-700">
                            View direction
                          </button>
                          <button className="text-green-600 text-sm hover:text-green-700">
                            View more details
                          </button>
                        </div>
                      </div>
                    </div>
                  ))
                ) : (
                  <div className="text-center p-4 text-gray-500">
                    {error || "Enter a location to search for hospitals"}
                  </div>
                )}
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
                    zoom={13}
                    onLoad={onMapLoad}
                  >
                    {hospitals.map((hospital) => (
                      <Marker
                        key={hospital.id}
                        position={{ lat: hospital.lat, lng: hospital.lng }}
                        onClick={() => setSelectedHospital(hospital)}
                      />
                    ))}

                    {selectedHospital && (
                      <InfoWindow
                        position={{
                          lat: selectedHospital.lat,
                          lng: selectedHospital.lng,
                        }}
                        onCloseClick={() => setSelectedHospital(null)}
                      >
                        <div className="p-2">
                          <h3 className="font-bold mb-2">
                            {selectedHospital.name}
                          </h3>
                          <p className="text-sm mb-1">
                            {selectedHospital.address}
                          </p>
                          {selectedHospital.phoneNumber && (
                            <p className="text-sm text-blue-600">
                              {selectedHospital.phoneNumber}
                            </p>
                          )}
                          {selectedHospital.rating && (
                            <p className="text-sm mt-1">
                              Rating: {selectedHospital.rating} ⭐
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
