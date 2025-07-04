import React, { useState, useEffect, JSX } from "react";
import { Navigate } from "react-router-dom";
import { useAuth } from "../../../context/AuthContext";

import "./CccdForm.scss";
import { DataValidsProps, ErrorLogProps, FormDataProps } from "../../../types/FormInterfaces";
import InputField from "../../ui/input/InputField";
import DatetimePicker from "../../ui/input/DatetimePicker";

const CccdForm = (): JSX.Element => {
    const {token, user} = useAuth();
    const friendlyNote = "Bạn đã cập nhật CCCD!";

    const [formData, setFormData] = useState<FormDataProps>({
        numCccd: "",
        dateBirth: "",
        gender: "",
        address: ""
    });

    const [errors, setErrors] = useState<ErrorLogProps>({
        numCccd: "",
        dateBirth: "",
        gender: "",
        address: ""
    });

    const valids: DataValidsProps = {

    }

    if(token === "" || user.isGuest()) return(<></>);

        // useEffect(() => {
        //     const fetchUser = async () => {
        //     if(token === "") return;
        //     try {
        //         // console.log(token);
        //         const data = await getBasicUserInfo(token);
        //         setUserInfo(data);
        //     } catch (error: any) {
        //         console.error(error);
        //     }
        //     };
    
        //     fetchUser();
        // }, [token]);

    return (
        <section className={`cccd-form-container`}>
            <h3>Thêm Căn cước công dân</h3>
            <form>
                <div className="image-form">

                </div>
                <div className="text-form">
                    <InputField
                        type="text"
                        name="numCccd"
                        id="numCccd"
                        placeholder="Số căn cước công dân"
                        value={formData.numCccd}
                        formData={formData}
                        setFormData={setFormData}
                        maxLength={12}
                        errors={errors}
                        setErrors={setErrors}    
                    />
                    <DatetimePicker
                        type="date"
                        name="dateBirth"
                        id="dateBirth"
                        value={String(formData.dateBirth)}
                        setFormData={setFormData}
                    />
                </div>
            </form>
        </section>
    );
};

export default CccdForm;