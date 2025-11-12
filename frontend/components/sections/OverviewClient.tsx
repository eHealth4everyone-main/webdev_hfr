"use client";

import React, { useState } from "react";
import Chart from "@/components/sections/overview/Chart";
import OverviewMap from "@/components/sections/overview/OverviewMap";
import Table from "@/components/sections/overview/Table";
import SelectComponent from "@/components/ui/SelectComponent";
import { GreenButton, Heading, WhiteButton } from "@/components/ui/Typography";

const OverviewClient = () => {
  const [view, setView] = useState<"map" | "chart" | "table">("map");

  return (
    <div className="pt-32 px-8">
      <div className="flex flex-wrap justify-between items-start gap-4 lg:gap-0">
        <div>
          <Heading>Overview</Heading>
        </div>

        <div className="flex flex-wrap lg:flex-nowrap gap-2">
          <SelectComponent />
          <SelectComponent />
          <GreenButton className="w-[180px]">Search</GreenButton>
        </div>

        <div className="flex flex-wrap gap-2">
          <WhiteButton
            className={
              view === "map"
                ? "bg-[#5BBA62] text-white border-0"
                : "transparent"
            }
            onClick={() => setView("map")}
          >
            Map
          </WhiteButton>

          <WhiteButton
            className={
              view === "chart"
                ? "bg-[#5BBA62] text-white border-0"
                : "transparent"
            }
            onClick={() => setView("chart")}
          >
            Chart
          </WhiteButton>

          <WhiteButton
            className={
              view === "table"
                ? "bg-[#5BBA62] text-white border-0"
                : "transparent"
            }
            onClick={() => setView("table")}
          >
            Table
          </WhiteButton>
        </div>
      </div>

      <div className="w-full max-w-full min-h-[400px] mt-8">
        {view === "map" && <OverviewMap />}
        {view === "chart" && <Chart />}
        {view === "table" && <Table />}
      </div>
    </div>
  );
};

export default OverviewClient;
