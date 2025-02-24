import {
  GoogleMap,
  InfoWindow,
  LoadScript,
  Polygon,
  Marker,
} from "@react-google-maps/api";
// import nigeriaStatePolygon from "@/data/nigeria-states.json";
// import nigeriaStatePolygon from "@/data/nigeriaStates";
import nigeriaStatePolygon from "../../../public/data/nigeria-states.json";
import { useEffect, useRef, useState } from "react";

const polygonOptions = {
  fillColor: "#2D5F5D",
  fillOpacity: 0.6,
  strokeColor: "#fff",
  strokeWeight: 1,
};

const containerStyle = {
  width: "100%",
  height: "500px",
};

const center = {
  lat: 9.082, // Nigeria's center latitude
  lng: 8.6753, // Nigeria's center longitude
};

// Restrict map to Nigeria's bounding box
const bounds = {
  north: 14,
  south: 4,
  west: 2.5,
  east: 15.5,
};

// Function to style states
const getPolygonOptions = (stateName: string) => ({
  fillColor: stateName === "Kaduna" ? "#A6CE39" : "#4A7D8C", // Highlight Kaduna
  fillOpacity: 0.7,
  strokeColor: "#ffffff",
  strokeWeight: 1.5,
});

const NigeriaMap: React.FC = () => {
  //   const [selectedState, setSelectedState] = useState(null);

  // Example: Fake hospital data (Replace with real data)
  //   const hospitalData = {
  //     Kaduna: 1539,
  //     Lagos: 2100,
  //     Kano: 1800,
  //     Rivers: 1200,
  //     // Add for other states...
  //   };

  // Function to get color based on hospital count
  //   const getColor = (stateName) => {
  //     const count = hospitalData[stateName] || 0;
  //     if (count > 2000) return "#00441b"; // Dark green (High)
  //     if (count > 1500) return "#238b45"; // Medium green
  //     if (count > 1000) return "#66c2a4"; // Light green
  //     return "#ccece6"; // Very light green (Low)
  //   };

  const [mapsLoaded, setMapsLoaded] = useState(false);

  useEffect(() => {
    if (window.google?.maps) setMapsLoaded(true);
  }, []);

  return (
    <LoadScript
      googleMapsApiKey={process.env.NEXT_PUBLIC_GOOGLE_MAP_API ?? ""}
      onLoad={() => setMapsLoaded(true)}
    >
      <GoogleMap
        mapContainerStyle={containerStyle}
        center={center}
        zoom={6}
        options={{
          restriction: { latLngBounds: bounds, strictBounds: true },
          streetViewControl: false,
          mapTypeControl: false,
        }}
      >
        {nigeriaStatePolygon.features.map((state, index) => {
          const stateName = state.properties.name;
          const stateCenter = {
            lat: state.geometry.coordinates[0][0][1],
            lng: state.geometry.coordinates[0][0][0],
          };

          return (
            <div key={index}>
              <Polygon
                paths={state.geometry.coordinates.map((polygon) =>
                  polygon.map((ring) =>
                    ring.map((coord) => ({ lat: coord[1], lng: coord[0] }))
                  )
                )}
                options={{
                  fillColor: "#4A7D8C",
                  fillOpacity: 0.7,
                  strokeColor: "#ffffff",
                  strokeWeight: 1.5,
                }}
              />
              {mapsLoaded && (
                <Marker
                  position={stateCenter}
                  label={{
                    text: stateName,
                    fontSize: "12px",
                    color: "black",
                  }}
                  icon={{
                    path: window.google.maps.SymbolPath.CIRCLE,
                    scale: 0, // Hide default marker
                  }}
                />
              )}
            </div>
          );
        })}
      </GoogleMap>
    </LoadScript>
  );
};

export default NigeriaMap;
