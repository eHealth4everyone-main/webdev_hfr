"use client";

import React from "react";
import { useEffect } from "react";

export default function OverviewClient() {
  useEffect(() => {
    const divElement = document.getElementById("viz1765138662074");
    if (!divElement) return;

    const vizElement = divElement.getElementsByTagName("object")[0];

    const updateSize = () => {
      const containerWidth = divElement.offsetWidth;
      
      // Set width to 100% of container
      vizElement.style.width = "100%";
      
      // Calculate height based on aspect ratio (16:9 or adjust as needed)
      // Or use a fixed minimum height
      const calculatedHeight = Math.max(600, containerWidth * 0.6); // 60% aspect ratio
      vizElement.style.height = `${calculatedHeight}px`;
    };

    // Initial size
    updateSize();

    // Load Tableau JS API dynamically
    const scriptElement = document.createElement("script");
    scriptElement.src = "https://public.tableau.com/javascripts/api/viz_v1.js";
    if (vizElement.parentNode) {
      vizElement.parentNode.insertBefore(scriptElement, vizElement);
    }

    // Update on window resize with debounce
    let resizeTimer: NodeJS.Timeout;
    const handleResize = () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(updateSize, 250);
    };

    window.addEventListener("resize", handleResize);
    return () => {
      window.removeEventListener("resize", handleResize);
      clearTimeout(resizeTimer);
    };
  }, []);

  return (
    <div className="w-full mt-20 px-4 max-w-[1600px] mx-auto">
      {/* Added max-width and center alignment */}
      <div
        className="tableauPlaceholder w-full"
        id="viz1765138662074"
        style={{ position: "relative" }}
      >
        <noscript>
          <a href="#">
            <img
              alt="Nigeria's Healthcare Facility Ownership Landscape"
              src="https://public.tableau.com/static/images/He/HealthFacilityRegistryDashboardNew/NigeriasHealthcareFacilityOwnershipDashboar/1_rss.png"
              style={{ border: "none", width: "100%" }}
            />
          </a>
        </noscript>

        <object className="tableauViz w-full" style={{ display: "none" }}>
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