import { FileText } from "lucide-react";
import { GreenButton } from "../ui/Typography";

const resources = [
  "M&E Framework for MFL and HFR in Nigeria",
  "M&E Framework for MFL and HFR in Nigeria",
  "M&E Framework for MFL and HFR in Nigeria",
  "M&E Framework for MFL and HFR in Nigeria",
];

export default function ResourceX() {
  return (
    <div className="max-w-5xl mx-auto p-6">
      <h2 className="text-2xl font-bold">Resources</h2>
      <p className="text-gray-600 mt-2">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis.
      </p>

      <div className="bg-green-100 text-green-800 p-3 rounded-md mt-4 font-medium">
        Public Resources
      </div>

      <div className="mt-4 space-y-4">
        {resources.map((resource, index) => (
          <div
            key={index}
            className="flex items-center justify-between p-4 border rounded-lg shadow-sm"
          >
            <div className="flex items-center space-x-3 p-0">
              <FileText className="text-blue-500" size={24} />
              <span className="text-medium font-400">{resource}</span>
            </div>
            <GreenButton className="bg-green-500 hover:bg-green-600 text-white">
              Download file
            </GreenButton>
          </div>
        ))}
      </div>
    </div>
  );
}
