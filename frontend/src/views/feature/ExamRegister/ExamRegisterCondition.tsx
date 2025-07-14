import {JSX, useEffect, useState} from 'react';
import { useSearchParams } from "react-router-dom";
import { GetExamExist } from '../../../api/StudentExam';
import { fetchListKyThi } from '../../../api/FetchKyThi';
import ExistExam from './ExistExam';
import EmptyList from './EmptyListDK';
import { FormDataProps } from '../../../types/FormInterfaces';
import Dropdown from '../../ui/input/Dropdown';

const ExamRegisterCondition = ({token = ""}: {token: string}):JSX.Element => {
    const [jsx, setJsx] = useState<JSX.Element>(<></>)

    useEffect(() => {
        const GetData = async () => {
            try{
                const resultExam = await GetExamExist(token);
                console.log(resultExam);
                if(resultExam){
                    setJsx(<ExistExam/>);
                    return;
                }

                const resultList = await fetchListKyThi();
                if(!resultList.data || resultList.data.length === 0){
                    setJsx(<EmptyList/>);
                    return;
                }

                setJsx(<ExamRegisterContainer listDK={resultList.data}/>);

                console.log(resultList);
            }catch(error: any){
                console.error(error);
            }
        }

        if(token) GetData();
    },[token])

    return(jsx);
}

export default ExamRegisterCondition;

const ANH_XA = [
    {value: "dh", label: "Đại học"},
    {value: "cd", label: "Cao đẳng"},
    {value: "lt", label: "Liên thông"}
];

const ExamRegisterContainer = ({listDK}: {listDK: string[]}): JSX.Element => {
    const [searchParams] = useSearchParams();
    const type = searchParams.get("type") || "";

    const filtered = Object.fromEntries(
        Object.entries(ANH_XA).filter(([value]) => listDK.includes(value))
    );

    const [formData, setFormData] = useState<FormDataProps>({
        typeExam: type,
        monTC: "",
        monNN: "",
    })

    return(
    <div className='exam-register-container'>
        <h2>Đăng ký kỳ thi</h2>
        <form>
            <Dropdown
                name="typeExam"
                id="typeExam"
                choices={Object.values(filtered)}
                value={String(formData.typeExam)}
                setFormData={setFormData}
                label="kỳ thi"
            />
        </form>
    </div>
    );
}

