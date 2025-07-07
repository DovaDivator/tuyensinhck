import React, {JSX, useEffect, useRef, useState} from 'react';
import InputImage from '../../ui/input/InputImage';
import InputField from '../../ui/input/InputField';
import InputChoice from '../../ui/input/InputChoice';
import DatetimePicker from '../../ui/input/DatetimePicker';
import { ErrorLogProps, FileDataProps, FormDataProps } from '../../../types/FormInterfaces';

import "./CccdForm.scss";

interface CccdFormProps{
    formData: FormDataProps;
    setFormData: React.Dispatch<React.SetStateAction<FormDataProps>>;
    imgData: FileDataProps;
    setImgData: React.Dispatch<React.SetStateAction<FileDataProps>>;
    errors: ErrorLogProps;
    setErrors: React.Dispatch<React.SetStateAction<ErrorLogProps>>;
    isAdmin?: boolean;
}

    const GENDER_CHOICES = [
        {value: "0", label: "Nam"},
        {value: "1", label: "Nữ"}
    ]

const CccdForm = ({
    formData,
    setFormData,
    imgData,
    setImgData,
    errors,
    setErrors,
    isAdmin = false
}: CccdFormProps): JSX.Element => {
    const formRef = useRef<HTMLFormElement>(null);
    const [sizeClass, setSizeClass] = useState<'big' | 'small'>('big');

    useEffect(() => {
        const formEl = formRef.current;
        if (!formEl) return;

        const observer = new ResizeObserver(entries => {
            for (let entry of entries) {
                const width = entry.contentRect.width;
                if (width < 650) {
                    setSizeClass('small');
                } else {
                    setSizeClass('big');
                }
            }
        });

        observer.observe(formEl);

        return () => observer.disconnect();
    }, []);

    return(
    <form ref={formRef} className='cccd-form'>
                <div className={`image-form ${sizeClass}`}>
                    <InputImage
                        name="front"
                        id="front"
                        value={Array.isArray(imgData.front) ? imgData.front[0] : imgData.front}
                        setFileData={setImgData}
                        disabled={isAdmin}
                    />
                    <InputImage
                        name="back"
                        id="back"
                        value={Array.isArray(imgData.back) ? imgData.back[0] : imgData.back}
                        setFileData={setImgData}
                        disabled={isAdmin}
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
    );
}

export default CccdForm;