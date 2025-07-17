import React, { useState, useEffect, JSX, useRef } from "react";
import { useAuth } from "../../../context/AuthContext";

import "./TraCuuExam.scss";
import { useAppContext } from "../../../context/AppContext";
import { getListExam } from "../../../api/StudentExam";

const TraCuuExam = (): JSX.Element => {
    const {token, user} = useAuth();
    const {isLoading, setIsLoading} = useAppContext();

    if(token === "" || user.isGuest()) return(<></>);
    
    const [data, setData] = useState<any[]>([]);

    useEffect(() => {
        const fetchData = async () => {
            try{
              const result = await getListExam(token);
              console.log(result);
            }catch(error: any){
              console.error(error);
            }
        };

        setIsLoading(true);
        if (token) fetchData();
        setIsLoading(false);
    }, [token]);

    return (
        <section className={`cccd-form-container`}>
            <h3>Tra cứu kỳ thi</h3>
        </section>
    );
};

export default React.memo(TraCuuExam);

const EmptyExamList = () =>{
  return(
    <div className='container text-center mt-5'>
      <div className='alert alert-warning'>
        <span>Có vẻ bạn chưa đăng ký kỳ thi nào của chúng tôi...</span>
      </div>
    </div>
  );
}