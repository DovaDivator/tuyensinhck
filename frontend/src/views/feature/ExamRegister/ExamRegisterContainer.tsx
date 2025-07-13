import {JSX, useEffect} from 'react';
import { GetExamExist } from '../../../api/StudentExam';
import { fetchListKyThi } from '../../../api/FetchKyThi';

const ExamRegisterContainer = ({token}: {token: string}):JSX.Element => {
    
    useEffect(() => {
        const GetData = async () => {
            try{
                const resultExam = await GetExamExist(token);
                console.log(resultExam);
                const resultList = await fetchListKyThi();
                console.log(resultList);
            }catch(error: any){
                console.error(error);
            }
        }
    },[])

    return(<></>);
}

export default ExamRegisterContainer;