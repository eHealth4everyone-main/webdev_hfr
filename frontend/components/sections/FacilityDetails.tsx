import Image from "next/image";
import React from "react";
import { Text } from "../ui/Typography";
import { MdLocationPin } from "react-icons/md";
import { FaRegShareSquare, FaDownload } from "react-icons/fa";
import { HiDownload } from "react-icons/hi";
import { HiShare } from "react-icons/hi";

const FacilityDetails = () => {
  return (
    <div className="flex flex-col gap-[1rem] lg:pt-32 mx-8 mb-8">
      <HospitalDetails />
      <div className="flex flex-col lg:flex-row gap-[2rem]">
        <div className="flex flex-col gap-[1rem]">
          <Image
            src={"/detailsImageOne.svg"}
            width={445}
            height={464}
            alt="img"
          />
          <Text className="underline text-[#5BBA62] cursor-pointer text-center">
            <MdLocationPin fontSize={24} color="#5BBA62" className="inline" />{" "}
            View direction
          </Text>
          <div className="flex gap-[.5rem]">
            <Image src={"/down1.svg"} width={95} height={131} alt="img" />
            <Image src={"/down2.svg"} width={95} height={131} alt="img" />
            <Image src={"/down3.svg"} width={95} height={131} alt="img" />
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
                <span className="font-semibold">Facility type:</span> Primary
                Health Care (PHC)
              </p>
              <p>
                <span className="font-semibold">Ownership:</span> Private
              </p>
              <p>
                <span className="font-semibold">Certificate of Standard:</span>{" "}
                Yes
              </p>
              <p>
                <span className="font-semibold">Contact info:</span>{" "}
                +23481010101010
              </p>
              <p>
                <span className="font-semibold">Unique ID:</span> 24567843
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
                <span className="font-semibold">State:</span> FCT
              </p>
              <p>
                <span className="font-semibold">LGA:</span> Municipal
              </p>
              <p>
                <span className="font-semibold">Ward:</span> Akanbi
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
                FCT
              </p>
              <p>
                <span className="font-semibold">No of Beds:</span> FCT
              </p>
              <p>
                <span className="font-semibold">No of Midwives:</span> FCT
              </p>
              <p>
                <span className="font-semibold">No of Nurses:</span> FCT
              </p>
              <p>
                <span className="font-semibold">No of Resident Doctors:</span>{" "}
                FCT
              </p>
              <p>
                <span className="font-semibold">No of Health workers:</span> FCT
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

const HospitalDetails = () => {
  return (
    <div className="flex flex-col md:flex-row items-center justify-between p-4 border-b bg-white">
      <div>
        <p className="text-sm text-gray-500">
          <span className="font-semibold">Hospital Finder</span> / Hospital
          details
        </p>
        <div className="flex items-center gap-2 mt-1">
          <h1 className="text-2xl font-bold">General Hospital</h1>
          <span className="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">
            Open 24hrs
          </span>
        </div>
        <p className="text-gray-500 text-sm flex items-center gap-1 mt-1">
          2417 Central Ave, Alameda, CA, 94501
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
