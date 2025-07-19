import React, { useState, useEffect, JSX, useRef } from "react";
import { useAuth } from "../../../context/AuthContext";

import "./TraCuuExam.scss";
import { useAppContext } from "../../../context/AppContext";
import { getListExam } from "../../../api/StudentExam";
import Card from "../../ui/components/Card";
import { processExamListTS } from "../../../function/convert/ProcessExamListTS";
import ListTable from "../../ui/components/ListTable";

const TraCuuExam = (): JSX.Element => {
    const {token, user} = useAuth();
    const {isLoading, setIsLoading} = useAppContext();

    if(token === "" || user.isGuest()) return(<></>);
    
    const [data, setData] = useState<any[]>([]);

    useEffect(() => {
        const fetchData = async () => {
            try{
              const result = await getListExam(token);
              if(result.data instanceof Array){
                setData(result.data);
              }else{
                setData([]);
              }
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
            {data.length === 0 &&
              <EmptyExamList/>
            }
            {data.length > 0 &&
              data.map((item, index) => (
                <div key={index}>
                  <EleKyThiInfo item={item}/>
                </div>
              ))
            }
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

const EleKyThiInfo = ({item} : {item: Object}): JSX.Element =>{
    console.log(item);

    const HEADERS = {
      mon_thi: "Môn thi",
      dateExam: "Ngày thi",
      timeStart: "Bắt đầu",
      timeEnd: "Kết thúc",
      maPhong: "Mã phòng",
      viTri: "Địa điểm",
      diem: "Điểm",
    }

    const convertItem = processExamListTS(item);
    console.log(convertItem);
    return(
      <Card>
        <ListTable
          struct={convertItem}
          headers={HEADERS}
        />
      </Card>
    );
}