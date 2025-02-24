import React from "react";
import SelectComponent from "../ui/SelectComponent";
import { GrUploadOption } from "react-icons/gr";
import ReportsTable from "./Tabs/ReportsTable";

const options = ["Lagos", "Abuja", "Kwara"];

const ReportX = () => {
  return (
    <div className="w-full p-4 sm:p-6">
      <div className="flex flex-col sm:flex-row items-center justify-between mb-4 gap-4 sm:gap-0">
        <div className="flex flex-col sm:flex-row items-center w-full sm:w-auto space-y-2 sm:space-y-0 sm:space-x-2">
          <SelectComponent options={options} className="w-full sm:w-[300px] lg:w-[400px]" />
          <button className="bg-green-500 hover:bg-green-600 text-white rounded-lg p-2 w-full sm:w-auto">
            Show
          </button>
        </div>
        <button className="w-full sm:w-[200px] border shadow-sm p-2 sm:p-3 rounded-lg flex items-center justify-center gap-2">
          <GrUploadOption size={16} />
          <span>Upload data</span>
        </button>
      </div>
      <hr className="border-[#f1f1f1]" />

      <div className="flex flex-col gap-4">
        <div className="bg-[#E8F0E2] p-4 mt-4 rounded-lg">
          <p>1 Facility was updated in the last 3 months</p>
        </div>

        <ReportsTable />
      </div>
    </div>
  );
};

export default ReportX;