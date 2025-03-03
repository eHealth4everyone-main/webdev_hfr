"use client";

import Header from "@/components/Header/Header";
import { Text } from "@/components/ui/Typography";
import { LayoutDashboard, Calendar } from "lucide-react";
import { usePathname } from "next/navigation";
import { MdExitToApp } from "react-icons/md";
import { PiDiamondsFour } from "react-icons/pi";
import { LuBuilding2 } from "react-icons/lu";
import { RiBuilding2Line } from "react-icons/ri";
import { LuArrowDownToLine } from "react-icons/lu";
import { GoFileDirectory } from "react-icons/go";
import { FiBook } from "react-icons/fi";

const topNavData = [
  {
    icon: PiDiamondsFour,
    text: "Overview",
    navitem: "Overview",
    link: "/overview",
  },
  {
    icon: LuBuilding2,
    text: "Facility Finder",
    navitem: "facilityfinder",
    link: "/facilityfinder",
  },
  {
    icon: RiBuilding2Line,
    text: "Facilities List",
    navitem: "facilitieslist",
    link: "/facilitieslist",
  },
];
const bottomNavData = [
  {
    icon: LuArrowDownToLine,
    text: "Data Downloads",
    navitem: "Data Downloads",
    link: "/datadownloads",
  },
  {
    icon: GoFileDirectory,
    text: "Resources",
    navitem: "resources",
    link: "/resources",
  },
  {
    icon: FiBook,
    text: "Reports",
    navitem: "reports",
    link: "/reports",
  },
];

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  const pathname = usePathname();
  return (
    <div className="flex flex-col">
      <Header />
      <div className="flex flex-col bg-white md:flex-row items-start lg:relative">
        <div className="hidden lg:block lg:fixed w-64 bg-white border-r border-gray-200 h-full pt-24">
          {/* Sidebar */}
          <aside>
            <div className="p-6">
              <h1 className="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <LayoutDashboard className="h-6 w-6 text-emerald-600" />
                Dashboard
              </h1>
            </div>
            <nav className="mt-6">
              <Text className="text-[#AEAEAE] px-6 py-1">Overview</Text>
              {topNavData.map((item, index) => (
                <a
                  key={index}
                  href={item.link}
                  className={`flex items-center py-3 text-gray-700 transition-colors ${
                    pathname === item.link
                      ? "bg-[#5BBA62] px-2 text-white mx-4 rounded-lg"
                      : "transparent px-6"
                  }`}
                >
                  <item.icon className="h-5 w-5 mr-3" />
                  {item.text}
                </a>
              ))}
            </nav>
            <nav className="mt-6">
              <Text className="text-[#AEAEAE] px-6 py-1">Resources</Text>
              {bottomNavData.map((item, index) => (
                <a
                  key={index}
                  href={item.link}
                  className={`flex items-center py-3 text-gray-700 transition-colors ${
                    pathname === item.link
                      ? "bg-[#5BBA62] px-2 text-white mx-4 rounded-lg"
                      : "transparent px-6"
                  }`}
                >
                  <item.icon className="h-5 w-5 mr-3" />
                  {item.text}
                </a>
              ))}
            </nav>
            <div className="flex gap-[.3rem] px-6 py-8 text-gray-700 hover:bg-gray-50 hover:text-emerald-600 transition-colors cursor-pointer">
              <MdExitToApp fontSize={24} color="red" />
              <Text className="text-[red]">Logout</Text>
            </div>
          </aside>
        </div>
        {/* Main Content */}
        <main className="lg:ml-64 flex-1 bg-gray-50">{children}</main>
      </div>
    </div>
  );
}
