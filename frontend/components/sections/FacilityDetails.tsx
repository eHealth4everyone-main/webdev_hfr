"use client";
import Image from "next/image";
import React, { useCallback, useEffect, useRef, useState } from "react";
import { Text } from "../ui/Typography";
import { MdLocationPin } from "react-icons/md";
import { FaRegShareSquare, FaDownload } from "react-icons/fa";
import { HiDownload } from "react-icons/hi";
import { HiShare } from "react-icons/hi";
import { useRouter, useSearchParams } from "next/navigation";
import axios from "axios";

import html2canvas from "html2canvas";
import { jsPDF } from "jspdf";

import "swiper/css";
import "swiper/css/navigation";

import Lightbox from "react-image-lightbox";
import "react-image-lightbox/style.css"; // Import the lightbox styles
import Swal from "sweetalert2";
import Certificate from "./Certificate";


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
  community_health_extension_worker?: number | null;
  jun_community_health_extension_worker?: number | null;
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
  certificate_no?: string | null;
  cert_issue_date?: string | null;
  cert_expiry_date?: string | null;
  cert_status?: string | null;
}


const FacilityDetails = () => {
  const router = useRouter();

  const searchParams = useSearchParams();
  const id = searchParams?.get("id"); // Get the hospital ID from URL

  const [hospital, setHospital] = useState<Facility | null>(null);

  const [fetchError, setFetchError] = useState<string>(""); // State for error messages

  const [isOpen, setIsOpen] = useState(false);
  const [currentIndex, setCurrentIndex] = useState(0);
  const [showCertificate, setShowCertificate] = useState(false);


  const getAFacility = useCallback(async (facilityId: string) => {
    try {
      const response = await axios.get(
        `${process.env.NEXT_PUBLIC_BACKEND_API}/facilities-hospital/${facilityId}`
      );

      const data = response?.data?.data?.hospital;
      console.log("Fetched facility:", data);
      setHospital(data);
    } catch (error) {
      console.error("Error fetching facility:", error);
      setFetchError("Failed to fetch facility details.");
    }
  }, []);

  useEffect(() => {
    const pathArray = window.location.pathname.split("/"); // Split URL by "/"
    const id = pathArray[pathArray.length - 1]; // Get the last part of the URL
    if (id) {
      getAFacility(id);
    }
  }, [id, getAFacility]);

  const parsedImages = JSON.parse((hospital as any)?.image_url || "[]");

  const imageUrl =
    Array.isArray(parsedImages) && parsedImages.length > 0
      ? parsedImages[0] // Get the first image
      : "/detailsImageOne.svg"; // Default placeholder image

  const openLightbox = (index: number) => {
    if (!parsedImages[index]) return;

    if (isOpen) {
      setIsOpen(false);
      setTimeout(() => {
        setCurrentIndex(index);
        setIsOpen(true);
      }, 100);
    } else {
      setCurrentIndex(index);
      setIsOpen(true);
    }
  };

  const closeLightbox = () => {
    setIsOpen(false);
  };

  const nextImage = () => {
    setCurrentIndex((currentIndex + 1) % parsedImages.length);
  };

  const prevImage = () => {
    setCurrentIndex(
      currentIndex === 0 ? parsedImages.length - 1 : currentIndex - 1
    );
  };

  const pdfRef = useRef<HTMLDivElement>(null);

  const fixColorsBeforeCapture = () => {
    document.querySelectorAll("*").forEach((el) => {
      const computedStyle = window.getComputedStyle(el);
      if (computedStyle.backgroundColor.includes("oklch")) {
        (el as HTMLElement).style.backgroundColor = "white"; // Change to a safe color
      }
    });
  };

  const downloadPDF = () => {
    if (!pdfRef.current) return; // Prevent error

    // Hide buttons before taking the screenshot
    document.querySelectorAll(".no-print").forEach((el) => {
      (el as HTMLElement).style.visibility = "hidden";
    });

    fixColorsBeforeCapture(); // Fix colors before capturing
    html2canvas(pdfRef.current, { scale: 2 }).then((canvas) => {
      const imgData = canvas.toDataURL("image/jpeg");
      const pdf = new jsPDF("l", "mm", "a4"); // "l" = Landscape mode
      const pageWidth = pdf.internal.pageSize.getWidth(); // Get landscape width
      const imgWidth = pageWidth - 40; // Reduce width to add padding (20mm left & right)
      const imgHeight = (canvas.height * imgWidth) / canvas.width;

      pdf.addImage(imgData, "JPEG", 20, 10, imgWidth, imgHeight); // 20mm padding from left
      pdf.save(`${hospital?.facility_name || "facility"}_details.pdf`);

      // Show buttons again after PDF is downloaded
      setTimeout(() => {
        document.querySelectorAll(".no-print").forEach((el) => {
          (el as HTMLElement).style.visibility = "visible";
        });
      }, 100);
    });
  };

  const apiKey = process.env.NEXT_PUBLIC_GOOGLE_MAP_API;

  const getAccurateLocation = async () => {
    try {
      const response = await fetch(
        `https://www.googleapis.com/geolocation/v1/geolocate?key=${apiKey}`,
        { method: "POST" }
      );
      const data = await response.json();

      if (data.location) {
        return { latitude: data.location.lat, longitude: data.location.lng };
      } else {
        throw new Error("Failed to get accurate location");
      }
    } catch (error) {
      console.error("Google Geolocation API Error:", error);
      return null;
    }
  };

  const handleViewDirections = async (hospital: Facility | null) => {
    if (!hospital?.id || !hospital.latitude || !hospital.longitude) {
      Swal.fire({
        icon: "warning",
        title: "Invalid Facility",
        text: "Facility location is missing or invalid.",
        confirmButtonText: "Okay",
      });
      return;
    }

    Swal.fire({
      title: "Getting your location...",
      text: "Please wait while we fetch your location.",
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading(),
    });

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          Swal.close();

          const userLat = position.coords.latitude;
          const userLng = position.coords.longitude;
          const facilityLat = hospital.latitude;
          const facilityLng = hospital.longitude;

          const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${facilityLat},${facilityLng}&travelmode=driving`;
          window.open(googleMapsUrl, "_blank");
        },
        async (error) => {
          console.warn("Geolocation Error:", error);
          const location = await getAccurateLocation();
          Swal.close();

          if (location) {
            const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${location.latitude},${location.longitude}&destination=${hospital.latitude},${hospital.longitude}&travelmode=driving`;
            window.open(googleMapsUrl, "_blank");
          } else {
            Swal.fire({
              icon: "error",
              title: "Location Error",
              text: "Unable to get your location. Please enable GPS or try another browser.",
              confirmButtonText: "Okay",
            });
          }
        },
        {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0,
        }
      );
    } else {
      const location = await getAccurateLocation();
      Swal.close();

      if (location) {
        const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${location.latitude},${location.longitude}&destination=${hospital.latitude},${hospital.longitude}&travelmode=driving`;
        window.open(googleMapsUrl, "_blank");
      } else {
        Swal.fire({
          icon: "error",
          title: "Geolocation Not Supported",
          text: "Your browser does not support geolocation. Please enable location services or try another device.",
          confirmButtonText: "Okay",
        });
      }
    }
  };

  return (
    <div ref={pdfRef} className="flex flex-col gap-[1rem] lg:pt-32 mx-8 mb-8">
      <HospitalDetails hospital={hospital} downloadPDF={downloadPDF} />

      <div className="flex flex-col lg:flex-row gap-[2rem]">
        <div className="flex flex-col gap-[1rem]">
          <Image src={imageUrl} width={445} height={464} alt="img" className="rounded-xl object-cover" />

          <Text
            className="underline text-[#5BBA62] cursor-pointer text-center no-print"
            onClick={() => handleViewDirections(hospital)}
          >
            <MdLocationPin fontSize={24} color="#5BBA62" className="inline" />{" "}
            View direction
          </Text>

          <div className="flex gap-[.5rem] gap-2">
            {parsedImages.slice(0, 3).map((img: any, index: number) => (
              <img
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
                className="w-[95px] h-[131px] flex items-center justify-center bg-black/50 text-white text-lg cursor-pointer rounded-md"
                onClick={() => openLightbox(3)}
              >
                +{parsedImages.length - 3}
              </div>
            )}

            {isOpen && parsedImages.length > 0 && (
              <Lightbox
                mainSrc={parsedImages[currentIndex]}
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
                reactModalStyle={{ overlay: { zIndex: 1050 } }}
              />
            )}
          </div>
        </div>

        <div className="flex-1 space-y-6">
          <div className="border rounded-xl shadow-sm p-6 bg-white">
            <div className="mb-4">
              <h3 className="text-green-600 font-semibold mb-2">General Information</h3>
              <div className="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                <p><span className="font-semibold text-gray-500">Facility type:</span> {(hospital as any)?.facility_type_name || "N/A"}</p>
                <p><span className="font-semibold text-gray-500">Ownership:</span> {(hospital as any)?.ownership_name || "N/A"}</p>
                <p><span className="font-semibold text-gray-500">Certificate of Standard:</span> {hospital?.certificate_no ? "Yes" : "No"}</p>
                <p><span className="font-semibold text-gray-500">Contact info:</span> {(hospital as any)?.phone_number || "N/A"}</p>
                <p><span className="font-semibold text-gray-500">Unique ID:</span> {hospital?.unique_id || "N/A"}</p>
                <p><span className="font-semibold text-gray-500">Facility Level:</span> {hospital?.facility_level_name || "N/A"}</p>
                {hospital?.certificate_no && (
                  <p><span className="font-semibold text-gray-500">Cert No:</span> {hospital.certificate_no}</p>
                )}
              </div>
            </div>

            <div className="mb-4 border-t pt-4">
              <h3 className="text-green-600 font-semibold mb-2">Location details</h3>
              <div className="grid grid-cols-3 gap-4 text-sm">
                <p><span className="font-semibold text-gray-500">State:</span> {hospital?.state_name || "N/A"}</p>
                <p><span className="font-semibold text-gray-500">LGA:</span> {hospital?.lga_name || "N/A"}</p>
                <p><span className="font-semibold text-gray-500">Ward:</span> {hospital?.ward_name || "N/A"}</p>
              </div>
            </div>

            <div className="mb-4 border-t pt-4">
              <h3 className="text-green-600 font-semibold mb-2">Facility Capacity info</h3>
              <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                <p><span className="font-semibold text-gray-500">Med Doctors:</span> {hospital?.doctors || 0}</p>
                <p><span className="font-semibold text-gray-500">Beds:</span> {hospital?.beds || 0}</p>
                <p><span className="font-semibold text-gray-500">Nurses:</span> {hospital?.nurses || 0}</p>
                <p><span className="font-semibold text-gray-500">Midwives:</span> {hospital?.midwifes || 0}</p>
              </div>
            </div>
          </div>

          {hospital?.certificate_no && (
            <div className="mt-8 flex flex-col items-center gap-4">
              <button
                onClick={() => setShowCertificate(!showCertificate)}
                className="px-8 py-3 bg-green-700 text-white rounded-full font-bold hover:bg-green-800 transition-all shadow-lg no-print hover:scale-105"
              >
                {showCertificate ? "Hide Certificate" : "View Official Certificate of Standards"}
              </button>

              {showCertificate && (
                <div className="w-full flex justify-center py-12 bg-gray-100 rounded-2xl shadow-inner animate-in fade-in zoom-in duration-300">
                  <Certificate
                    facilityName={hospital.facility_name}
                    certificateNo={hospital.certificate_no}
                    issueDate={hospital.cert_issue_date || ""}
                    expiryDate={hospital.cert_expiry_date || ""}
                    facilityLevel={hospital.facility_level_name || ""}
                    location={`${hospital.lga_name || ""}, ${hospital.state_name || ""}`}
                  />
                </div>
              )}
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default FacilityDetails;

const HospitalDetails = ({
  hospital,
  downloadPDF,
}: {
  hospital: Facility | null;
  downloadPDF: () => void;
}) => {
  const [copied, setCopied] = useState(false);

  const shareLocation = async () => {
    try {
      const urlToShare = window.location.href;
      if (navigator.share) {
        await navigator.share({
          title: `Check out ${hospital?.facility_name}`,
          text: "View details of this healthcare facility on HFR.",
          url: urlToShare,
        });
      } else {
        const fallbackUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(urlToShare)}`;
        window.open(fallbackUrl, "_blank");
      }
    } catch (error) {
      console.error("Error sharing:", error);
    }
  };

  return (
    <div className="flex flex-col md:flex-row items-center justify-between p-6 border rounded-xl bg-white shadow-sm mb-6">
      <div className="mb-4 md:mb-0">
        <p className="text-xs text-green-600 font-bold uppercase tracking-widest mb-1">
          Healthcare Facility Registry
        </p>
        <div className="flex items-center gap-3">
          <h1 className="text-3xl font-black text-gray-900">{hospital?.facility_name}</h1>
          <span className="text-xs font-bold bg-green-100 text-green-700 px-4 py-1.5 rounded-full border border-green-200">
            {hospital?.operational_hours ? `${hospital.operational_hours} HRS` : "N/A"}
          </span>
        </div>
        <p className="text-gray-500 text-sm flex items-center gap-1 mt-2 font-medium">
          <MdLocationPin className="text-green-600" size={18} />
          {hospital?.physical_location || `${hospital?.ward_name}, ${hospital?.lga_name}, ${hospital?.state_name}`}
        </p>
      </div>

      <div className="flex gap-3">
        <button
          className="flex no-print items-center gap-2 px-6 py-2.5 border-2 border-gray-100 rounded-full font-bold text-gray-600 hover:bg-gray-50 transition-all"
          onClick={shareLocation}
        >
          <HiShare /> {copied ? "Copied!" : "Share"}
        </button>
        <button
          className="flex no-print items-center gap-2 px-8 py-2.5 bg-black text-white rounded-full font-bold hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl"
          onClick={downloadPDF}
        >
          <HiDownload /> Download
        </button>
      </div>
    </div>
  );
};
