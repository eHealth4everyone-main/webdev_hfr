import React, { useState } from "react";
import { ChatBotWidget } from "chatbot-widget-ui";
import { Bot } from "lucide-react";

const Chatbot = () => {
    // Save all messages conversation
    // Example: [{'role': 'user', 'content': 'hello'}, {'role': 'assistant', 'content': 'Hello, how can I assist you today!'}, ...]
    const [messages, setMessages] = useState<any[]>([
        {
            role: "user",
            content: "hello",
        },
        {
            role: "assistant",
            content: "hi!",
        },
        {
            role: "user",
            content: "who are you",
        },
    ]);

    const customApiCall = async (message: string): Promise<string> => {
        const response = await fetch("https://n8n.e4eweb.space/webhook/d2a145a2-bbf6-4fc9-87c4-826f5f566cb4", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                question: message,
                "overrideConfig": {
                    "sessionId": "4672657373733"
                }
            }),
        });
        const data = await response.json();
        return data.output;
    };

    const handleBotResponse = (response: string) => {
        // Handle the bot's response here
        console.log("Bot Response:", response);
        setMessages((prevMessages) => [
            ...prevMessages,
            { role: "assistant", content: response },
        ]);
    };

    const handleNewMessage = (message: any) => {
        setMessages((prevMessages) => [...prevMessages, message]);
    };

    return (
        <div className="z-50 fixed bottom-0 right-0 m-4 w-80 h-96">
            <ChatBotWidget
                callApi={customApiCall}
                onBotResponse={handleBotResponse}
                handleNewMessage={handleNewMessage}
                messages={messages}
                primaryColor="#5bb85d"
                inputMsgPlaceholder="Type your message..."
                chatbotName="HFR Chatbot"
                isTypingMessage="Typing..."
                IncommingErrMsg="Oops! Something went wrong. Try again."
                chatIcon={<Bot size={40} className="" />}
                botIcon={<Bot size={30} className="text-center" />}
                botFontStyle={{
                    fontFamily: "Arial",
                    fontSize: "12px",
                    color: "#2f4f4f",
                }}
                typingFontStyle={{
                    fontFamily: "Arial",
                    fontSize: "12px",
                    color: "#888",
                    fontStyle: "italic",
                }}
                useInnerHTML={true}
            />
        </div>
    );
};

export default Chatbot;