import React, { useState, useEffect, JSX } from "react";
import { useAuth } from "../../../context/AuthContext";

import "./CccdEdit.scss";
import { DataValidsProps, ErrorLogProps, FileDataProps, FormDataProps } from "../../../types/FormInterfaces";
import InputField from "../../ui/input/InputField";
import DatetimePicker from "../../ui/input/DatetimePicker";
import { formatTimestamp } from "../../../function/convert/formatTimestamp";
import InputChoice from "../../ui/input/InputChoice";
import InputImage from "../../ui/input/InputImage";
import Button from "../../ui/input/Button";
import * as API from "../../../api/StudentCccd";

const CccdForm = (): JSX.Element => {
    const {token, user} = useAuth();
    const friendlyNote = ["Thông tin của bạn đang chờ phê duyệt!","Bạn đã cập nhật CCCD!"];
    const GENDER_CHOICES = [
        {value: "male", label: "Nam"},
        {value: "female", label: "Nữ"}
    ]

    const [isUpdated, setIsUpdated] = useState<boolean>(false);

    const [formData, setFormData] = useState<FormDataProps>({
        numCccd: "",
        dateBirth: formatTimestamp(new Date(new Date().getFullYear() - 18, 0, 1)), // Ngày 01/01 của 18 năm về trước
        gender: "",
        address: ""
    });

    const [imgData, setImgData] = useState<FileDataProps>({
        front: undefined,
        back: undefined
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

    useEffect(() => {
        const fetchData = async () => {
            try {
                const result = await API.GetCccd(token);
                console.log(result);
            } catch (error: any) {
                console.error(error);
            }
        };

        fetchData();
    }, []);

    const handleReset = () => {
        setFormData({
            numCccd: "",
            dateBirth: formatTimestamp(new Date(new Date().getFullYear() - 18, 0, 1)), // Ngày 01/01 của 18 năm về trước
            gender: "",
            address: ""
        });
        setImgData({
            front: undefined,
            back: undefined
        });
    }

    const handleSubmit = async () =>{
        //Hàm kiểm tra ở đây
        console.log("Kiểm tra thành công");
        //Thực hiện API cập nhật
        try{
            const result = await API.UpdateCccd(token, {...formData, ...imgData});
            console.log(result);
        }catch(error: any){
            console.error(error)
        }
    }

    return (
        <section className={`cccd-form-container`}>
            <h3>Thêm Căn cước công dân</h3>
            {isUpdated && <p className="note"></p>}
            <form>
                <div className="image-form">
                    <InputImage
                        name="front"
                        id="front"
                        value={Array.isArray(imgData.front) ? imgData.front[0] : imgData.front}
                        setFileData={setImgData}
                    />
                    <InputImage
                        name="back"
                        id="back"
                        value={Array.isArray(imgData.back) ? imgData.back[0] : imgData.back}
                        setFileData={setImgData}
                    />
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
                    <InputChoice
                        type="radio"
                        name="gender"
                        id="gender"
                        label="Giới tính"
                        value={formData.gender}
                        choices={GENDER_CHOICES}
                        setFormData={setFormData}
                        columns={2}
                    />
                    <InputField
                        type="text"
                        name="address"
                        id="address"
                        placeholder="Địa chỉ"
                        value={formData.address}
                        formData={formData}
                        setFormData={setFormData}
                        errors={errors}
                        setErrors={setErrors}    
                    />
                </div>
                
            </form>
            <div className="button-form">
                    <Button
                        type="submit"
                        className="btn-confirm"
                        onClick={handleSubmit}
                        text="Cập nhật!"
                    />
                    <Button
                        type="button"
                        className="btn-cancel"
                        onClick={handleReset}
                        text="Khôi phục"
                    />
                </div>
        </section>
    );
};

export default CccdForm;