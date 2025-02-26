import { Text } from "@/components/ui/Typography";
import React from "react";

const Process = () => {
  return (
    <div className="flex flex-col gap-[1.5rem] flex flex-col mt-[2rem] w-full lg:w-[1200px] px-8 lg:px-0 lg:mx-auto">
      <Text className="text-center font-semibold">The Process</Text>
      <Text className="w-full text-justify">
        The development of the HFR followed a consultative process among the
        different stakeholders working within the Federal Ministry of Health,
        its agencies and development partners.
      </Text>
      <Text className="w-full text-justify">
        The steps of the process followed are listed below:
      </Text>

      <ul className="list-disc flex flex-col gap-[1rem] w-full  lg:mx-[0]">
        <li className="w-full text-justify">
          Request and Authorization by the Honorable Minister to commence the
          process for modifying the MFL for the country.
        </li>
        <li className="w-full text-justify">
          Stakeholder’s workshop in August 2016 at Reiz Continental Hotel during
          which the classes of health facilities to be covered in the HFR and
          the data elements of importance for each class of health facility were
          identified.
        </li>
        <li className="w-full text-justify">
          Establishment of the MFL Technical Working Group co-chaired by the
          Department of Health Planning Research and Statistics and the
          Department of Hospital Services. Other members were the Department of
          Information and Communications Technology, National Primary Healthcare
          Development Agency, National Population Commission, National Bureau of
          Statistics, the UN agencies including the World Health Organization,
          World Bank, USAID, HISP Nigeria with technical support from MEASURE
          Evaluation.
        </li>
        <li className="w-full text-justify">
          Three state study (FCT, Lagos and Cross River) to understand health
          facility registration process variation and identify potential
          workflow issues to be built into the HFR. Also opportunity for the
          retrieval of data collection tools used by the different states.
        </li>
        <li className="w-full text-justify">
          Consultations with various regulatory agencies including a meeting
          between the HMH and all the regulatory agencies.
        </li>
        <li className="w-full text-justify">Finalization and approval of data elements for HFR.</li>
        <li>Development and testing of the HFR.</li>

        <li className="w-full text-justify">
          Harmonization of different health facility lists and upload into the
          HFR.
        </li>
        <li className="w-full text-justify">
          Presentation of the HFR to stakeholders (including the Honorable
          Minister of Health) and obtaining feedback for its improvement.
        </li>
        <li className="w-full text-justify">
          Development of draft implementation guidelines Release of HFR to the
          public.
        </li>
      </ul>
    </div>
  );
};

export default Process;
