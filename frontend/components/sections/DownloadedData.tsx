import React from "react";
import { GreenButton, Text } from "../ui/Typography";
import Input from "../ui/Input";
import TextArea from "../ui/TextArea";

const DownloadedData = () => {
  return (
    <div className="w-full lg:w-[900px] mx-auto lg:pt-32">
      <div className="mx-2 lg:mx-0">
        <Text className="text-2xl font-bold mb-2">Data Downloads</Text>
        <Text className="text-[#363636]">
          Thank you for your interest in Nigeria HFR data, kindly sign our guest
          form to download the data.
        </Text>
      </div>

      <div className="border shadow-sm rounded-lg p-8 mt-4">
        <form className="flex flex-col gap-[1rem]">
          <div className="flex flex-col lg:flex-row gap-[2rem]">
            <Input label="First name" placeholder="first name" className="" />
            <Input label="Last name" placeholder="last name" />
          </div>
          <div className="flex flex-col lg:flex-row gap-[2rem]">
            <Input
              label="Email Address"
              type="email"
              placeholder="e.g ade@gmail.com"
            />
            <Input label="Organization" placeholder="organization" />
          </div>
          <div className="flex flex-col lg:flex-row gap-[2rem]">
            <Input label="Designation" type="text" placeholder="designation" />
            <Input label="Country" placeholder="e.g Nigeria" />
          </div>
          <TextArea label="Purpose" placeholder="Intended usage of data" />
          <div className="flex justify-end">
            <GreenButton className="bg-[#5BBA62]">Submit request</GreenButton>
          </div>
        </form>
      </div>
    </div>
  );
};

export default DownloadedData;
