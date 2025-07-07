import React, { useState, useEffect, JSX, useRef } from "react";
import { useSearchParams } from "react-router-dom";
import { useAuth } from "../../../context/AuthContext";

import "../info/CccdEdit.scss";
import { DataValidsProps, ErrorLogProps, FileDataProps, FormDataProps } from "../../../types/FormInterfaces";
import { formatTimestamp } from "../../../function/convert/formatTimestamp";
import Button from "../../ui/input/Button";
import * as API from "../../../api/StudentCccd";
import CccdForm from "../info/CccdForm";
import { convertFileDataToBase64 } from "../../../function/convert/convertFileDataToBase64";

const ManagerCccdContainer = (): JSX.Element => {
    const {token, user} = useAuth();
    const STATUS_COMFIRM = ["Đang chờ phê duyệt!","Đã phê duyệt!"];
    const [searchParams] = useSearchParams();
    const stu_id = searchParams.get("id") || "";

    const defaultFormRef = useRef<FormDataProps | null>(null);
    const defaultImgRef = useRef<FileDataProps | null>(null);


    const [isUpdated, setIsUpdated] = useState<number>(-1);

    const [formData, setFormData] = useState<FormDataProps>({
        realName: "",
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
        realName: "",
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
            if(!stu_id){
                setIsUpdated(-1);
                return;
            }

            try {
                const result = await API.GetCccd(token);
                console.log(result);

                // Giả sử result có dạng {form: {...}, image: {...}}
                const form = {
                    realName: result.realName || "",
                    numCccd: result.numCccd || "",
                    dateBirth: result.dateBirth || formatTimestamp(new Date(new Date().getFullYear() - 18, 0, 1)),
                    gender: result.gender || "",
                    address: result.address || ""
                };

                const image = {
                    front: result.front,
                    back: result.back
                };

                // Set dữ liệu hiển thị
                setFormData(form);
                setImgData(image);

                // Lưu bản sao gốc
                defaultFormRef.current = form;
                defaultImgRef.current = image;
            } catch (error: any) {
                console.error(error);
            }
        };

        if (token) fetchData();
    }, [token]);

    const handleReset = () => {
        if (defaultFormRef.current && defaultImgRef.current) {
            setFormData(defaultFormRef.current);
            setImgData(defaultImgRef.current);
        } else {
            console.warn("Dữ liệu mặc định chưa được khởi tạo");
        }
    };

    const handleSubmit = async () =>{
        //Hàm kiểm tra ở đây
        console.log("Kiểm tra thành công");
        //Thực hiện API cập nhật
        const base64Data = await convertFileDataToBase64(imgData);
        try{
            const result = await API.UpdateCccd(token, {...formData, ...base64Data});
            console.log(result);
        }catch(error: any){
            console.error(error)
        }
    }

    // if(isUpdated === -1){
    //     return(
    //         <div className="container text-center mt-5">
    //             <div className="alert alert-warning" role="alert">
    //                 <h4 className="alert-heading">Không tìm thấy CCCD!</h4>
    //                 <p>Thông tin xác thực của người này không tồn tại hoặc bị xóa trong hệ thống.</p>
    //             </div>
    //         </div>
    //     );
    // }

    return (
        <section className={`cccd-form-container`}>
            <h3>Xác thực CCCD: </h3>
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
                        text="Xác thực!"
                    />
                    <Button
                        type="button"
                        onClick={handleReset}
                        text="Khôi phục"
                    />
                    <Button
                        type="button"
                        className="btn-cancel"
                        onClick={handleReset}
                        text="Loại bỏ!"
                    />
                </div>
        </section>
    );
};

export default React.memo(ManagerCccdContainer);