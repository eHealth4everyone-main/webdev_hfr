"use client";
import React, { useRef } from "react";
import { HiDownload } from "react-icons/hi";
import html2canvas from "html2canvas";
import { jsPDF } from "jspdf";

interface CertificateProps {
    facilityName: string;
    certificateNo: string;
    issueDate: string;
    expiryDate: string;
    facilityLevel: string;
    location: string;
}

const Certificate: React.FC<CertificateProps> = ({
    facilityName,
    certificateNo,
    issueDate,
    expiryDate,
    facilityLevel,
    location,
}) => {
    const certRef = useRef<HTMLDivElement>(null);

    const downloadCertificate = () => {
        if (!certRef.current) return;

        html2canvas(certRef.current, { scale: 3, useCORS: true }).then((canvas) => {
            const imgData = canvas.toDataURL("image/png");
            const pdf = new jsPDF("l", "mm", "a4");
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            pdf.addImage(imgData, "PNG", 0, 0, pageWidth, pageHeight);
            pdf.save(`Certificate_${facilityName}.pdf`);
        });
    };

    return (
        <div className="flex flex-col items-center gap-4 p-8 bg-gray-50 rounded-xl border">
            <div
                ref={certRef}
                className="relative w-[1123px] h-[794px] bg-white shadow-2xl overflow-hidden border-[16px] border-double border-green-800 p-12 flex flex-col items-center justify-between text-center"
                style={{ fontFamily: "'Playfair Display', serif" }}
            >
                {/* Background Watermark/Logo */}
                <div className="absolute inset-0 opacity-5 pointer-events-none flex items-center justify-center">
                    <img src="/logo.png" alt="watermark" width={600} height={600} className="object-contain" />
                </div>

                {/* Header */}
                <div className="z-10 flex flex-col items-center gap-4">
                    <div className="flex items-center gap-6">
                        <img src="/Coat_of_arms_of_Nigeria.svg" alt="Coat of Arms" width={100} height={100} />
                    </div>
                    <h1 className="text-4xl font-bold uppercase tracking-widest text-green-900">Federal Republic of Nigeria</h1>
                    <h2 className="text-2xl font-semibold text-green-800">Federal Ministry of Health</h2>
                    <div className="h-1 w-64 bg-green-800 my-2"></div>
                    <h3 className="text-5xl font-black text-green-900 mt-4 uppercase tracking-tighter">Certificate of Standards</h3>
                    <p className="text-lg italic text-gray-600 mt-2">In compliance with the National Health Act</p>
                </div>

                {/* Content */}
                <div className="z-10 flex flex-col items-center gap-6 w-full px-20">
                    <p className="text-2xl text-gray-700">This is to certify that</p>
                    <h4 className="text-5xl font-bold text-gray-900 border-b-2 border-gray-400 pb-2 px-8 min-w-[60%]">
                        {facilityName}
                    </h4>

                    <div className="grid grid-cols-2 gap-12 text-left w-full mt-8">
                        <div className="space-y-4">
                            <p className="text-xl">
                                <span className="text-gray-500 uppercase text-sm block tracking-widest font-bold">Facility Level</span>
                                <span className="font-semibold text-2xl">{facilityLevel}</span>
                            </p>
                            <p className="text-xl">
                                <span className="text-gray-500 uppercase text-sm block tracking-widest font-bold">Location</span>
                                <span className="font-semibold text-xl">{location}</span>
                            </p>
                        </div>
                        <div className="space-y-4 text-right">
                            <p className="text-xl">
                                <span className="text-gray-500 uppercase text-sm block tracking-widest font-bold">Certificate Number</span>
                                <span className="font-mono font-bold text-2xl text-red-700">{certificateNo}</span>
                            </p>
                            <p className="text-xl">
                                <span className="text-gray-500 uppercase text-sm block tracking-widest font-bold">Issue Date</span>
                                <span className="font-semibold text-xl">{new Date(issueDate).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' })}</span>
                            </p>
                        </div>
                    </div>
                </div>

                {/* Footer/Signatures */}
                <div className="z-10 flex justify-between items-end w-full px-20">
                    <div className="text-center">
                        <div className="w-48 border-b border-gray-900 mb-2"></div>
                        <p className="text-sm font-bold uppercase">Director Health Services</p>
                    </div>

                    <div className="flex flex-col items-center bg-green-50 p-4 border-2 border-green-200 rounded-lg">
                        <div className="text-xs text-green-800 font-bold mb-1">VALID UNTIL</div>
                        <div className="text-xl font-bold text-green-900">
                            {new Date(expiryDate).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' })}
                        </div>
                    </div>

                    <div className="text-center">
                        <div className="w-48 border-b border-gray-900 mb-2"></div>
                        <p className="text-sm font-bold uppercase">Honorable Minister of Health</p>
                    </div>
                </div>

                {/* Seal */}
                <div className="absolute bottom-12 right-12">
                    <img src="/nigeria_health_seal_1772103534426.png" alt="Official Seal" width={160} height={160} className="drop-shadow-xl" />
                </div>
            </div>

            <button
                onClick={downloadCertificate}
                className="flex items-center gap-2 px-8 py-4 bg-green-700 text-white rounded-full font-bold hover:bg-green-800 transition-all shadow-lg no-print transform hover:scale-105"
            >
                <HiDownload size={24} /> Download Certificate (PDF)
            </button>
        </div>
    );
};

export default Certificate;
