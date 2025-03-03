import { Text } from "@/components/ui/Typography";
import React from "react";

const Origin = () => {
  return (
    <div className="bg-[#F2F2F2] p-8 w-full ">
      <div className="lg:w-[1200px] mx-auto flex flex-col gap-[1.5rem]">
        <Text className="font-semibold text-center">The Origin</Text>
        <Text className="text-justify">
          The Nigeria Health Facility Registry (HFR) was developed in 2017 as
          part of effort to dynamically manage the Master Health Facility List
          (MFL) in the country. The MFL "is a complete listing of health
          facilities in a country (both public and private) and is comprised of
          a set of identification items for each facility (signature domain) and
          basic information on the service capacity of each facility (service
          domain)".
        </Text>
        <Text className="text-justify">
          The Federal Ministry of Health had previously identified the need for
          an information system to manage the MFL in light of different
          shortcomings encountered in maintaining an up-to-date paper based MFL.
          The benefits of the HFR are numerous including serving as the hub for
          connecting different information systems thereby enabling integration
          and interoperability, eliminating duplication of health facility lists
          and for planning the establishment of new health facilities.
          Elaboration on the use cases of importance for which the HFR should
          address was subsequently made.
        </Text>
      </div>
    </div>
  );
};

export default Origin;
