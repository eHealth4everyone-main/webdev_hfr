/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: "https",
        hostname: "daisyui.com",
        port: "",
      },
      {
        protocol: "https",
        hostname: "img.daisyui.com",
        port: "",
      },
      {
        protocol: "https",
        hostname: "storage.googleapis.com",
        port: "",
      },
      // {
      //   protocol: "https",
      //   hostname: "C:\fakepath\"",
      //   port: "",
      // },
    ],
  },
};

export default nextConfig;
