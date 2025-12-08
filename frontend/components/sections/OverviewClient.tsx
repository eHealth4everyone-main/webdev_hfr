"use client";

import React, { useState } from "react";
import Chart from "@/components/sections/overview/Chart";
import OverviewMap from "@/components/sections/overview/OverviewMap";
import Table from "@/components/sections/overview/Table";
import SelectComponent from "@/components/ui/SelectComponent";
import { GreenButton, Heading, WhiteButton } from "@/components/ui/Typography";
import { useEffect } from "react";

export default function OverviewClient() {
  useEffect(() => {
    const divElement = document.getElementById("viz1765138662074");
    if (!divElement) return;

    const vizElement = divElement.getElementsByTagName("object")[0];

    // Responsive sizing
    if (divElement.offsetWidth > 800) {
      vizElement.style.width = "1350px";
      vizElement.style.height = "677px";
    } else if (divElement.offsetWidth > 500) {
      vizElement.style.width = "1350px";
      vizElement.style.height = "677px";
    } else {
      vizElement.style.width = "100%";
      vizElement.style.height = "1727px";
    }

    // Load Tableau JS API dynamically
    const scriptElement = document.createElement("script");
    scriptElement.src = "https://public.tableau.com/javascripts/api/viz_v1.js";
    vizElement.parentNode.insertBefore(scriptElement, vizElement);
  }, []);

  return (
    <div className="w-full mt-20 px-4">
      {/* Tableau Embed */}
      <div
        className="tableauPlaceholder"
        id="viz1765138662074"
        style={{ position: "relative" }}
      >
        <noscript>
          <a href="#">
            <img
              alt="Nigeria’s Healthcare Facility Ownership Landscape"
              src="https://public.tableau.com/static/images/He/HealthFacilityRegistryDashboardNew/NigeriasHealthcareFacilityOwnershipDashboar/1_rss.png"
              style={{ border: "none" }}
            />
          </a>
        </noscript>

        <object className="tableauViz" style={{ display: "none" }}>
          <param name="host_url" value="https%3A%2F%2Fpublic.tableau.com%2F" />
          <param name="embed_code_version" value="3" />
          <param name="site_root" value="" />
          <param
            name="name"
            value="HealthFacilityRegistryDashboardNew/NigeriasHealthcareFacilityOwnershipDashboar"
          />
          <param name="tabs" value="no" />
          <param name="toolbar" value="yes" />
          <param
            name="static_image"
            value="https://public.tableau.com/static/images/He/HealthFacilityRegistryDashboardNew/NigeriasHealthcareFacilityOwnershipDashboar/1.png"
          />
          <param name="animate_transition" value="yes" />
          <param name="display_static_image" value="yes" />
          <param name="display_spinner" value="yes" />
          <param name="display_overlay" value="yes" />
          <param name="display_count" value="yes" />
          <param name="language" value="en-US" />
        </object>
      </div>
    </div>
  );
}
