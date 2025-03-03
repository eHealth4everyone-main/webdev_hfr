import Image from "next/image";
import SectionContainer from "../ui/SectionContainer";
import { Text } from "../ui/Typography";

export const InteractiveSearch = () => {
  return (
    <div>
      <SectionContainer>
        <div className='flex flex-col md:flex-row justify-center items-center gap-[3rem]'>
          <div className='flex flex-col gap-[1rem]'>
            <Text className='font-[600] '>
              Interactive <span className='text-[#5CB85C]'>Search & Filter</span>
            </Text>

            <Text className='font-[400] w-full lg:w-[440px]'>Easily locate health facilities by name, location, type, or services using dynamic filters for precise results.</Text>
          </div>
          <Image src={"/interactive-filter.svg"} width={472} height={360} alt='img' />
        </div>
      </SectionContainer>
    </div>
  );
};

export const DataVisualization = () => {
  return (
    <div>
      <SectionContainer>
        <div className='flex flex-col md:flex-row justify-center items-center gap-[3rem]'>
          <Image src={"/data-visual.svg"} width={472} height={360} alt='img' />
          <div className='flex flex-col gap-[1rem]'>
            <Text className='font-[600] '>
              Data
              <span className='text-[#5CB85C]'>Visualizations</span>
            </Text>

            <Text className='font-[400]  w-full lg:w-[440px]'>Easily locate health facilities by name, location, type, or services using dynamic filters for precise results.Charts, graphs, and maps to present key health facility data in an easily interpretable format.</Text>
          </div>
        </div>
      </SectionContainer>
    </div>
  );
};

export const PublicResources = () => {
  return (
    <div>
      <SectionContainer>
        <div className='flex flex-col md:flex-row justify-center items-center gap-[3rem]'>
          <div className='flex flex-col gap-[1rem]'>
            <Text className='font-[600] '>
              Public <span className='text-[#5CB85C]'>Resources</span>
            </Text>

            <Text className='font-[400]  w-full lg:w-[440px]'>Access to downloadable reports, guidelines, and FAQs to improve transparency.</Text>
          </div>
          <Image src={"/public-resource.svg"} width={472} height={360} alt='img' />
        </div>
      </SectionContainer>
    </div>
  );
};
