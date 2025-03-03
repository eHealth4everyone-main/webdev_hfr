"use client";

import Chart from "@/components/sections/overview/Chart";
import OverviewMap from "@/components/sections/overview/OverviewMap";
import Table from "@/components/sections/overview/Table";
import SelectComponent from "@/components/ui/SelectComponent";

import { GreenButton, Heading, WhiteButton } from "@/components/ui/Typography";
import React, { useState } from "react";

const Overview = () => {
  const [map, setMap] = useState<boolean>(true);
  const [chart, setChart] = useState<boolean>(false);
  const [table, setTable] = useState<boolean>(false);
  return (
    <div className="pt-32 mx-[2rem]">
      <div className="flex flex-wrap justify-between items-start gap-[1rem] lg:gap-0">
        <div>
          <Heading>Overview</Heading>
        </div>
        <div className="flex flex-wrap lg:flex-nowrap gap-[.5rem] ">
          <SelectComponent className="" />
          <SelectComponent className="" />
          <GreenButton className="w-[180px]">Search</GreenButton>
        </div>
        <div className="flex flex-wrap">
          <WhiteButton
            className={`${
              map ? "bg-[#5BBA62] text-white border-0" : "transparent"
            }`}
            onClick={() => {
              setMap(!map);
              setChart(false);
              setTable(false);
            }}
          >
            Map
          </WhiteButton>
          <WhiteButton
            className={`${
              chart ? "bg-[#5BBA62] text-white border-0" : "transparent"
            }`}
            onClick={() => {
              setChart(!chart);
              setMap(false);
              setTable(false);
            }}
          >
            Chart
          </WhiteButton>
          <WhiteButton
            className={`${
              table ? "bg-[#5BBA62] text-white border-0" : "transparent"
            }`}
            onClick={() => {
              setTable(!table);
              setChart(false);
              setMap(false);
            }}
          >
            Table
          </WhiteButton>
        </div>
      </div>

      <div>
        {map && <OverviewMap />}
        {chart && <Chart />}
        {table && <Table />}
      </div>
    </div>
  );
};

export default Overview;
