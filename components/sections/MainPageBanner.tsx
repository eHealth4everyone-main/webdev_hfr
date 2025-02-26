"use client";
import { FaArrowRight, FaLocationDot } from "react-icons/fa6";
import { useRouter, usePathname } from "next/navigation";
import AvatarGroup from "../ui/Avatar";
import Image from "next/image";

type BannerProps = {
  image: string;
  firstbtnLink?: string;
  secondbtnLink?: string;
  firstBtnTitle?: string;
  secondBtnTitle?: string;
  paragraph?: string;
  heading?: string;
};
export type itemsProps = {
  items: BannerProps;
  index: number;
};

const MainPageBanner = ({ items, index }: itemsProps) => {
  const { heading, paragraph, firstbtnLink, secondbtnLink, firstBtnTitle, secondBtnTitle, image } = items;
  const { push } = useRouter();
  const pathname = usePathname();
  const isTalentPath = pathname === "/for-talents";
  return (
    <div
      className={` relative ${index === 0 ? "mb-10" : "mb-20"} md:mb-0 py-2 sm:py-20 font-bold w-full px-4 mt-20 lg:mt-20 sm:px-10 `}
      style={{
        // backgroundImage: `linear-gradient(
        //     rgba(0, 0, 0, 0.5),
        //     rgba(0, 0, 0, 0.5)
        //   ), url('/bg-fac.png')`,

        backgroundImage: `linear-gradient(
            rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.5)
          ), url(${image})`,
        backgroundPosition: "center top",
        backgroundSize: "cover",
        height: "100%",
        overflowX: "hidden",
        overflowY: "hidden",
      }}
    >
      <div className=' container lg:mx-auto'>
        <div className={`flex flex-col-reverse lg:flex-row justify-center gap-10 sm:gap-10 md:pt-[3rem] items-center`} style={{ overflowX: "hidden" }}>
          <div className=' flex flex-col md:justify-left items-left gap-[1.5rem]  w-[100%] '>
            <h1 className={`md:leading-[1.2] break-words leading-[1] font-[700]  w-[100%] text-[#fff] text-left  md:text-5xl text-4xl mt-[1rem] lg:mt-[0]`}>{heading}</h1>
            <h1 className={`md:leading-[5rem] break-words leading-[1] font-[700] w-[100%] text-[#fff] text-left md:text-6xl text-4xl `}>
              Health <span className='text-[#5CB85C]'>Facilities</span>
            </h1>
            <p className=' break-words  text-left  md:leading-[25px] text-[#fff] font-[400] w-[auto] lg:w-[650px]'>{paragraph}</p>
            <div className='flex justify-center items-center gap-[.2rem] bg-[#5CB85C] w-[200px] rounded-lg p-3 cursor-pointer'>
              <FaLocationDot color='#fff' fontSize={24} />
              <p className='text-[#fff] font-[400]' onClick={() => push("/finder")}>
                Find Now
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
export default MainPageBanner;
