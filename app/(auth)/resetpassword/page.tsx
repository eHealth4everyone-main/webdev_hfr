import React from "react";

const ResetPassword: React.FC = () => {
  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-100">
      <div className="flex flex-col lg:flex-row items-center bg-white shadow-lg rounded-lg max-w-4xl">
        {/* Left Section - Illustration */}
        <div className="hidden lg:block lg:w-1/2 p-6 bg-[#F5F7FA]">
          <img
            src="/SideBar.svg"
            alt="Reset Password Illustration"
            className="w-full h-auto"
          />
        </div>

        {/* Right Section - Form */}
        <div className="w-full lg:w-1/2 p-8">
          {/* Logo */}
          <div className="text-center mb-6">
            <img src="/new-logo.svg" alt="Logo" className="mx-auto h-16" />
          </div>

          {/* Title */}
          <h1 className="text-xl font-semibold text-gray-800 text-center mb-2">
            NIGERIA Health Facility Registry (HFR)
          </h1>
          <p className="text-gray-600 text-center mb-6">
            Reset Password
            <br />
            Login to Access your Dashboard
          </p>

          {/* Form */}
          <form className="space-y-4">
            <div>
              <label
                htmlFor="email"
                className="block text-sm font-medium text-gray-700"
              >
                Email Address
              </label>
              <input
                type="email"
                id="email"
                placeholder="Enter Email Address"
                className="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
              />
            </div>

            <div>
              <label
                htmlFor="new-password"
                className="block text-sm font-medium text-gray-700"
              >
                New Password
              </label>
              <input
                type="password"
                id="new-password"
                placeholder="Enter New Password"
                className="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
              />
            </div>

            <div>
              <label
                htmlFor="confirm-password"
                className="block text-sm font-medium text-gray-700"
              >
                Confirm Password
              </label>
              <input
                type="password"
                id="confirm-password"
                placeholder="Re-enter New Password"
                className="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
              />
            </div>

            <div>
              <button
                type="submit"
                className="w-full py-2 px-4 bg-green-600 text-white font-medium rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
              >
                Reset Password
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default ResetPassword;
