"use client";

import Input from "@/components/ui/Input";
import { Heading, Text } from "@/components/ui/Typography";
import * as Yup from "yup";

import Image from "next/image";
import Link from "next/link";
import React from "react";
import { ResetPassword } from "@/types/authType";
import { Field, FieldProps, Form, Formik, FormikHelpers } from "formik";
import { usePasswordChangeNotificationMutation } from "@/redux/services/authService";
import { MdError } from "react-icons/md";
import Spinner from "@/components/ui/Spinner";
import { toast } from "react-toastify";
import { ForgotPasswordMessage } from "@/components/auth/ForgotPasswordMessage";

const ForgotPassword = () => {
  const [passwordChangeNotification, { data, error, isLoading }] =
    usePasswordChangeNotificationMutation();
  const initialValues: ResetPassword = {
    emailaddress: "",
  };

  const validationSchema = Yup.object({
    emailaddress: Yup.string().email().required("email is required"),
  });

  const onSubmit = async (
    values: ResetPassword,
    { setSubmitting }: FormikHelpers<ResetPassword>
  ) => {
    try {
      await passwordChangeNotification(values).unwrap();
    } catch (err: any) {
      toast.error(err!.data?.message);
      console.error("Error status:", err!.status);
      console.error("Error message:", err!.data?.message);
    }
  };
  if (error)
    return (
      <div className="px-[2rem] md:px-[0] flex flex-col gap-[1rem] justify-center items-center">
        <Image src={"/authlogo.svg"} width={87} height={40} alt="logo" />
        <Heading>Error, Send Email try again later</Heading>

        <div className="px-[2rem] md:px-[0] flex flex-col gap-[1rem] justify-center items-center"></div>
        <div className="flex flex-col justify-center items-start w-[100%] md:w-[400px] gap-[1rem]">
          <p className="text-sm mx-[10px] justify-start font-bold"></p>
        </div>
      </div>
    );

  return data ? (
    <>
      <ForgotPasswordMessage />
    </>
  ) : (
    <>
      <div className="px-[2rem] md:px-[0] flex flex-col gap-[1rem] justify-center items-center">
        <Image src={"/authlogo.svg"} width={87} height={40} alt="logo" />
        <Heading>Forgot Password</Heading>
        <Text>We’ll send a password reset link to your email</Text>
        <Formik
          initialValues={initialValues}
          validationSchema={validationSchema}
          onSubmit={onSubmit}
        >
          {({ errors, touched, isSubmitting }) => (
            <Form>
              <div className="flex flex-row justify-center items-center w-[100%] md:w-[400px]"></div>
              <div className="flex flex-col justify-center items-center w-[100%] md:w-[400px] gap-[1rem]">
                <>
                  <Field name="emailaddress">
                    {({ field }: FieldProps) => (
                      <Input placeholder="Enter email" {...field} />
                    )}
                  </Field>
                  {errors.emailaddress && touched.emailaddress && (
                    <div className="text-error flex gap-1 items-center">
                      <MdError fontSize={"1rem"} />
                      <p className="text-sm text-error">
                        {errors.emailaddress}
                      </p>
                    </div>
                  )}
                </>

                <button
                  disabled={isSubmitting}
                  type="submit"
                  className="text-white bg-[#078586] p-2 rounded-lg w-full md:w-[400px]"
                >
                  {isSubmitting ? " Sending ..." : "Send Password Reset Link"}
                </button>

                <Text className="inline">
                  Recall Password?{" "}
                  <Link
                    href="/createaccount"
                    className="text-[#078586] cursor-pointer"
                  >
                    Back to Log in
                  </Link>
                  {/* <span></span> */}
                </Text>
              </div>
            </Form>
          )}
        </Formik>
      </div>
    </>
  );
};

export default ForgotPassword;
