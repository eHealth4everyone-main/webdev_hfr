import React, { useState } from "react";
import { GreenButton, Text } from "../ui/Typography";
import Input from "../ui/Input";
import SelectComponent from "../ui/SelectComponent";

const Overlay = () => {
  // State for select inputs
  const [facilityType, setFacilityType] = useState("");
  const [location, setLocation] = useState("");

  // Options for the select inputs
  const facilityOptions = ["Hospital", "Clinic", "Pharmacy"];
  const locationOptions = ["Nigeria", "New York", "Los Angeles", "Chicago"];

  return (
    <div className='bg-[#F5F7FA] mx-auto md:w-[1200px] rounded-lg md:h-[268px] mt-[-7rem] z-50 pt-[1rem] flex flex-col justify-center items-center'>
      <Text className='font-[600] text-center'>
        Facility <span className='text-[#5CB85C]'>Finder</span>
      </Text>

      <Text className='font-[400] text-center'>Search for Health Facilities Close To You</Text>
      <div className='flex flex-wrap lg:flex-nowrap mx-[1rem] lg:mx-[0] justify-center items-center gap-[1rem] mt-[1rem]'>
        <Input className='mt-[-.3rem]' />

        {/* Facility Type Select */}
        <SelectComponent label='' options={facilityOptions} value={facilityType} onChange={(e) => setFacilityType(e.target.value)} placeholder='Select Facility Type' />

        {/* Location Select */}
        <SelectComponent label='' options={locationOptions} value={location} onChange={(e) => setLocation(e.target.value)} placeholder='Select Location' />

        <GreenButton className='w-[250px]'>Search</GreenButton>
      </div>
    </div>
  );
};

export default Overlay;
