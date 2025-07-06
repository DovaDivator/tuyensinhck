import React, { useState, useEffect, JSX } from "react";
import { useAuth } from "../../../context/AuthContext";

import "./CccdEdit.scss";
import { DataValidsProps, ErrorLogProps, FileDataProps, FormDataProps } from "../../../types/FormInterfaces";
import { formatTimestamp } from "../../../function/convert/formatTimestamp";
import Button from "../../ui/input/Button";
import * as API from "../../../api/StudentCccd";
import CccdForm from "./CccdForm";

const CccdEdit = (): JSX.Element => {
    const {token, user} = useAuth();
    const friendlyNote = ["Thông tin của bạn đang chờ phê duyệt!","Bạn đã cập nhật CCCD!"];

    const [isUpdated, setIsUpdated] = useState<number>(-1);

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

        if (token) fetchData();
    }, [token]);

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
            <CccdForm
                formData={formData}
                setFormData={setFormData}
                imgData={imgData}
                setImgData={setImgData}
                errors={errors}
                setErrors={setErrors}
            />
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

export default React.memo(CccdEdit);