const SectionContainer = ({
  children,
  className,
}: {
  children: React.ReactNode;
  className?: string;
}) => {
  return (
    <div
      className={`lg:mx-auto container flex flex-col gap-[3rem]  lg:gap-[3rem]  px-4 md:px-0 ${className}`}
    >
      {children}
    </div>
  );
};
export default SectionContainer;
