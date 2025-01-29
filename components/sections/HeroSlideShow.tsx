"use client";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/pagination";
import "../../app/swiperstyles.css";

import { Pagination, Autoplay, Navigation } from "swiper/modules";
import { FaArrowLeft, FaArrowRight } from "react-icons/fa";
import MainPageBanner from "./MainPageBanner";

const SwiperData = [
  {
    heading: "Discover Nigeria’s ",
    paragraph: " Join TechAccess accurate, up-to-date information on healthcare facilities across Nigeria. Find the care you need, where you need it.",
    firstBtnTitle: "Hire Talent",
    secondBtnTitle: "Apply for Jobs",
    image: "/bg-fac.png",
    firstbtnLink: "/company-register",
    secondbtnLink: "/talent-register",
  },
  {
    heading: "Discover Nigeria’s ",
    paragraph: "Access accurate, up-to-date information on healthcare facilities across Nigeria. Find the care you need, where you need it.",
    firstBtnTitle: "Get Started",
    image: "/4.png",
    firstbtnLink: "/company-register",
  },
  {
    heading: "Discover Nigeria’s",
    paragraph: "Access accurate, up-to-date information on healthcare facilities across Nigeria. Find the care you need, where you need it.",
    firstBtnTitle: "Hire Talent",
    image: "/5.png",
    firstbtnLink: "/talent-register",
  },
  {
    heading: "Discover Nigeria’s ",
    paragraph: "Access accurate, up-to-date information on healthcare facilities across Nigeria. Find the care you need, where you need it.",
    firstBtnTitle: "Apply for Jobs",
    image: "/6.png",
    firstbtnLink: "/company-register",
  },
  {
    heading: "Discover Nigeria’s ",
    paragraph: "Access accurate, up-to-date information on healthcare facilities across Nigeria. Find the care you need, where you need it.",
    firstBtnTitle: "Apply for Jobs",
    image: "/3.png",
    firstbtnLink: "/company-register",
  },
];

const HeroSlideShow = () => {
  return (
    <div className='relative'>
      <Swiper
        autoplay={{
          delay: 4000,
          disableOnInteraction: true,
        }}
        className='swiper'
        navigation={{ nextEl: ".next", prevEl: ".prev" }}
        spaceBetween={30}
        pagination={{
          clickable: true,
        }}
        modules={[Autoplay, Pagination, Navigation]}
      >
        {SwiperData.map((items, index) => (
          <SwiperSlide key={index}>
            <MainPageBanner items={items} index={index} />
          </SwiperSlide>
        ))}
      </Swiper>
    </div>
  );
};
export default HeroSlideShow;
