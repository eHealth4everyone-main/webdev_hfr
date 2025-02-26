const SectionContainer = ({ children }: { children: React.ReactNode }) => {
  return (
    <div className="lg:mx-auto container flex flex-col gap-[3rem]  lg:gap-[3rem]  px-4 md:px-0 ">
      {children}
    </div>
  );
};
export default SectionContainer;
