import AboutHero from "@/components/sections/about/AboutHero";
import Origin from "@/components/sections/about/Origin";
import Process from "@/components/sections/about/Process";
import Speech from "@/components/sections/about/Speech";
import React from "react";

const About = () => {
  return (
    <div className="pt-[4.5rem] lg:pt-[6rem]">
      <AboutHero />
      <Origin />
      <Process />
      <Speech />
    </div>
  );
};

export default About;
