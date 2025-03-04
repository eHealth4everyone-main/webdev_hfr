"use client";
import Image from "next/image";
import React, { useCallback, useEffect, useState } from "react";
import { Text } from "../ui/Typography";
import { MdLocationPin } from "react-icons/md";
import { FaRegShareSquare, FaDownload } from "react-icons/fa";
import { HiDownload } from "react-icons/hi";
import { HiShare } from "react-icons/hi";
import { useRouter, useSearchParams } from "next/navigation";
// import { useRouter } from "next/router";
import axios from "axios";

import "swiper/css";
import "swiper/css/navigation";

import Lightbox from "react-image-lightbox";
import "react-image-lightbox/style.css"; // Import the lightbox styles

const FacilityDetails = () => {
  const searchParams = useSearchParams();
  const id = searchParams?.get("id"); // Get the hospital ID from URL

  const [hospital, setHospital] = useState(null);

  const [fetchError, setFetchError] = useState<string>(""); // State for error messages

  const [modalIsOpen, setModalIsOpen] = useState(false);
  const [selectedImage, setSelectedImage] = useState(null);

  const [isOpen, setIsOpen] = useState(false);
  const [currentIndex, setCurrentIndex] = useState(0);
  const [mainSrc, setMainSrc] = useState("");

  const getAFacility = useCallback(async (facilityId: string) => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facilities-hospital/${facilityId}`
      );

      const data = response?.data?.data?.hospital;
      // console.log("Fetched facility:", data);
      setHospital(data);
    } catch (error) {
      console.error("Error fetching facility:", error);
      setFetchError("Failed to fetch facility details.");
    }
  }, []);

  useEffect(() => {
    const pathArray = window.location.pathname.split("/"); // Split URL by "/"
    const id = pathArray[pathArray.length - 1]; // Get the last part of the URL
    // console.log("Extracted ID:", id);
    if (id) {
      getAFacility(id);
    }
  }, [id, getAFacility]); // Add getAFacility as a dependency

  // const parsedImages = JSON.parse(hospital?.image_url || "[]"); // Default to an empty array
  const parsedImages = JSON.parse((hospital as any)?.image_url || "[]");

  const imageUrl =
    Array.isArray(parsedImages) && parsedImages.length > 0
      ? parsedImages[0] // Get the first image
      : "/detailsImageOne.svg"; // Default placeholder image

  const displayedImages = parsedImages.slice(0, 2); // Show only the first 3 images
  const extraCount = parsedImages.length - 3; // Count remaining images

  console.log({ imageUrl });

  const openModal = (imageUrl: any) => {
    setSelectedImage(imageUrl);
    setModalIsOpen(true);
  };

  const closeModal = () => {
    setModalIsOpen(false);
  };

  const openLightbox = (index: any) => {
    setCurrentIndex(index);
    setMainSrc(parsedImages[index]); // ✅ Set the image source immediately
    setIsOpen(true);
  };

  const closeLightbox = () => {
    setIsOpen(false);
    setMainSrc("");
  };

  const nextImage = () => {
    const nextIndex = (currentIndex + 1) % parsedImages.length;
    setCurrentIndex(nextIndex);
    setMainSrc(parsedImages[nextIndex]);
  };

  const prevImage = () => {
    const prevIndex =
      currentIndex === 0 ? parsedImages.length - 1 : currentIndex - 1;
    setCurrentIndex(prevIndex);
    setMainSrc(parsedImages[prevIndex]);
  };
  return (
    <div className="flex flex-col gap-[1rem] lg:pt-32 mx-8 mb-8">
      <HospitalDetails hospital={hospital} />

      <div className="flex flex-col lg:flex-row gap-[2rem]">
        <div className="flex flex-col gap-[1rem]">
          <Image src={imageUrl} width={445} height={464} alt="img" />
          <Text className="underline text-[#5BBA62] cursor-pointer text-center">
            <MdLocationPin fontSize={24} color="#5BBA62" className="inline" />{" "}
            View direction
          </Text>
          <div className="flex gap-[.5rem] gap-2">
            {parsedImages.slice(0, 2).map((img: any, index: any) => (
              <Image
                key={index}
                src={img}
                width={95}
                height={131}
                alt={`Image ${index + 1}`}
                className="cursor-pointer rounded-md object-cover"
                onClick={() => openLightbox(index)}
              />
            ))}

            {parsedImages.length > 3 && (
              <div
                className="w-[120px] h-[120px] flex items-center justify-center bg-black/50 text-white text-lg cursor-pointer rounded-md"
                onClick={() => openLightbox(3)}
              >
                +{parsedImages.length - 3}
              </div>
            )}

            {isOpen && parsedImages.length > 0 && (
              <Lightbox
                mainSrc={mainSrc}
                nextSrc={parsedImages[(currentIndex + 1) % parsedImages.length]}
                prevSrc={
                  parsedImages[
                    (currentIndex - 1 + parsedImages.length) %
                      parsedImages.length
                  ]
                }
                onCloseRequest={closeLightbox}
                onMovePrevRequest={prevImage}
                onMoveNextRequest={nextImage}
                reactModalStyle={{ overlay: { zIndex: 1050 } }} // Ensure it's above other elements
              />
            )}
          </div>
        </div>
        <div className="border rounded-xl shadow-sm p-6 bg-white">
          {/* General Information */}
          <div className="mb-4">
            <h3 className="text-green-600 font-semibold mb-2">
              General Information
            </h3>
            <div className="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
              <p>
                <span className="font-semibold">Facility type:</span>{" "}
                {(hospital as any)?.facility_type || "N/A"}
              </p>
              <p>
                <span className="font-semibold">Ownership:</span>{" "}
                {(hospital as any)?.ownership_name || "N/A"}
              </p>
              <p>
                <span className="font-semibold">Certificate of Standard:</span>{" "}
                Yes
              </p>
              <p>
                <span className="font-semibold">Contact info:</span>{" "}
                {(hospital as any)?.phone_number || "N/A"}
              </p>
              <p>
                <span className="font-semibold">Unique ID:</span>{" "}
                {(hospital as any)?.unique_id || "N/A"}
              </p>
            </div>
          </div>

          {/* Location Details */}
          <div className="mb-4 border-t pt-4">
            <h3 className="text-green-600 font-semibold mb-2">
              Location details
            </h3>
            <div className="grid grid-cols-3 gap-4 text-sm">
              <p>
                <span className="font-semibold">State:</span>{" "}
                {(hospital as any)?.state_name || "N/A"}
              </p>
              <p>
                <span className="font-semibold">LGA:</span>{" "}
                {(hospital as any)?.lga_name || "N/A"}
              </p>
              <p>
                <span className="font-semibold">Ward:</span>{" "}
                {(hospital as any)?.ward_name || "N/A"}
              </p>
            </div>
          </div>

          {/* Facility Capacity Info */}
          <div className="mb-4 border-t pt-4">
            <h3 className="text-green-600 font-semibold mb-2">
              Facility Capacity info
            </h3>
            <div className="grid grid-cols-3 md:grid-cols-6 gap-4 text-sm">
              <p>
                <span className="font-semibold">No of Medical Doctors:</span>{" "}
                {(hospital as any)?.doctors || "N/A"}
              </p>
              <p>
                <span className="font-semibold">No of Beds:</span>{" "}
                {(hospital as any)?.beds || "N/A"}
              </p>
              <p>
                <span className="font-semibold">No of Midwives:</span>{" "}
                {(hospital as any)?.nurse_midwife || "N/A"}
              </p>
              <p>
                <span className="font-semibold">No of Nurses:</span>{" "}
                {(hospital as any)?.nurses || "N/A"}
              </p>
              <p>
                <span className="font-semibold">No of Resident Doctors:</span>{" "}
                {(hospital as any)?.doctors || "N/A"}
              </p>
              <p>
                <span className="font-semibold">No of Health workers:</span>{" "}
                {(hospital as any)?.community_health_officer || "N/A"}
              </p>
            </div>
          </div>

          {/* Plans Accepted */}
          <div className="border-t pt-4">
            <h3 className="text-green-600 font-semibold mb-2">
              Plans accepted
            </h3>
            <p className="text-sm">
              Exclusive Provider Organization (EPO), HMO, Medi-Cal Managed Care,
              Point-of-Service Plan (POS), Senior Advantage.
            </p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default FacilityDetails;

const HospitalDetails = ({ hospital }: { hospital: any }) => {
  return (
    <div className="flex flex-col md:flex-row items-center justify-between p-4 border-b bg-white">
      <div>
        <p className="text-sm text-gray-500">
          <span className="font-semibold">Hospital Finder</span> / Hospital
          details
        </p>
        <div className="flex items-center gap-2 mt-1">
          <h1 className="text-2xl font-bold">{hospital?.facility_name}</h1>
          <span className="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">
            {/* Open 24hrs */}
            Open {hospital?.operational_hours + "hrs"}
          </span>
        </div>
        <p className="text-gray-500 text-sm flex items-center gap-1 mt-1">
          {/* 2417 Central Ave, Alameda, CA, 94501 */}
          {hospital?.physical_location}
          <span className="text-gray-400">📍</span>
        </p>
      </div>

      <div className="flex gap-2">
        <button className="flex items-center gap-2 px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
          <HiShare /> Share
        </button>
        <button className="flex items-center gap-2 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
          <HiDownload /> Download
        </button>
      </div>
    </div>
  );
};
