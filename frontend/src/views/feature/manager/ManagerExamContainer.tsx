import React,{JSX, useState, useEffect, useRef} from 'react';
import { parsePath, useLocation, useNavigate, useSearchParams} from "react-router-dom";
import { useAuth } from '../../../context/AuthContext';

import { jsxEleProps } from '../../../types/jsxElementInterfaces';
import './ManagerUserList.scss';
import ListTable from '../../ui/components/ListTable';
import InputField from '../../ui/input/InputField';
import { DataValidsProps, ErrorLogProps, FormDataProps} from '../../../types/FormInterfaces';
import InputChoice from '../../ui/input/InputChoice';
import { ChoiceGroup } from '../../../classes/ChoiceGroup';
import Button from '../../ui/input/Button';
import Pagination from '../../ui/components/Pagination';
import Dropdown from '../../ui/input/Dropdown';
import { useAppContext } from '../../../context/AppContext';
import { fetchKyThi } from '../../../api/FetchKyThi';
import DatetimePicker from '../../ui/input/DatetimePicker';
import Card from '../../ui/components/Card';
import { parseFlexibleDate } from '../../../function/convert/parseFlexibleDate';
import { DateValids } from '../../../classes/DateValids';

const HEADERS = {
    loaiThiLabel: "Cấp bậc",
    khoa: "Khóa thi",
    timeStart: "Thời gian mở",
    timeEnd: "Thời gian đóng",
    dateExam: "Ngày tổ chức",
    status: "Tình trạng",
    isAdd: "Bổ sung?"
}
const ANH_XA = [
    {value: "dh", label: "Đại học"},
    {value: "cd", label: "Cao đẳng"},
    {value: "lt", label: "Liên thông"}
];

const ANH_XA_STATUS = [
  <span className='unknown'>Không xác định</span>,
  <span className='accept'>Đã qua kỳ thi</span>,
  <span className='warning'>Trong kỳ thi</span>,
  <span className='denied'>Đã đóng</span>,
  <span className='accept'>Đang mở</span>,
  <span className='unknown'>Chưa mở</span>,
]

const DATE_POINT = (() => {
  const d = new Date();
  d.setDate(d.getDate() + 1);
  d.setHours(7, 0, 0, 0);
  return d;
})();

const ManagerExamContainer = ({className = ""}: jsxEleProps): JSX.Element =>{
    const {token} = useAuth();
    const {isLoading, setIsLoading} = useAppContext();
    const navigate = useNavigate();

    const [error, setError] = useState<string>("");
    const [typeCase, setTypeCase] = useState<any>({type: ""});
    const [data, setData] = useState<Object[]>([]);
    const [statusNum, setStatusNum] = useState<number>(0);

    const [searchParams] = useSearchParams();
    useEffect(() => {
      const typeUrl = searchParams.get("type") || "";
      setTypeCase({ type: typeUrl });
    }, [searchParams]);

    const [formData, setFormData] = useState<FormDataProps>({
      timeStart: "",
      timeEnd: "",
      dateExam: "",
      isAdd: "",
    });

    const defaultFormRef = useRef<FormDataProps | null>(null);

    const [errors, setErrors] = useState<ErrorLogProps>({
      timeStart: "",
      timeEnd: "",
      dateExam: "",
      isAdd: "",
    });

    const [valids, setValids] = useState<DataValidsProps>({
      timeStart: new DateValids({
        required: true,
        cons: {
          min: DATE_POINT
        },
      }),
      timeEnd: new DateValids({
        required: true,
        cons: {
          min: "timeStart"
        },
        dist: {
          day: 1,
        }
      }),
      dateExam: new DateValids({
        required: true,
        cons: {
          min: "timeEnd"
        },
        dist: {
          day: 7,
        }
      }),
    })

    useEffect(() => {
      const statusCase = (row : Object): number =>{
        if(!("timeStart" in row && "timeEnd" in row && "dateExam" in row)) return 0; 
          // return (<span className='unknown'>Không xác định</span>);

        const nowDate = new Date();
        const dayExam = parseFlexibleDate("07:00 " + row.dateExam);
        
        const durationOne = dayExam.getTime() - nowDate.getTime();
        if(durationOne < -36 * 60 * 60 * 1000) return 1;
          // return (<span className='denied'>Đã thi xong!</span>);

        if(durationOne < 24 * 60 * 60 * 1000) return 2;
          // return (<span className='warming'>Đang trong kỳ thi</span>);

        const durationTwo = nowDate.getTime() - parseFlexibleDate(String(row.timeEnd)).getTime();
        if(durationTwo > 0) return 3;

        const durationThree = nowDate.getTime() - parseFlexibleDate(String(row.timeStart)).getTime();
        if(durationThree > 0) return 4;

        return 5;
      }

        const getData = async () => {
          setIsLoading(true);
          setError("");
    
              try {
                const result = await fetchKyThi();
                console.log(result);
                setData(
                  result.data.map((row: any) => {
                    const matched = ANH_XA.find(item => item.value === row.loaiThi);
                    const statusCaseNum = statusCase(row);
                    
                    return {
                      ...row,
                      loaiThiLabel: matched?.label || "Không xác định", // Ghi đè hoặc thêm mới loaiThi (nếu bạn muốn giữ lại key)
                      statusEffect: statusCaseNum,
                      status: ANH_XA_STATUS[statusCaseNum],
                    };
                  })
                );
                
                const check = ANH_XA.find(item => item.value === typeCase.type);
                if (check && searchParams.get("type") !== check.value) {
                  const item: any = data.find(row => (row as any).loaiThi === typeCase.type);
                  const formDataTemp = {
                    timeStart: item.timeStart ? item.timeStart : "",
                    timeEnd: item.timeEnd ? item.timeEnd : "",
                    dateExam: item.dateExam ? item.dateExam : "",
                    isAdd: item.isAdd,
                  }
                  setFormData(formDataTemp);
                  defaultFormRef.current = formDataTemp
                }

              } catch (err) {
                console.error(err);
              } finally {
                setIsLoading(false);
              }
            };
    
            getData();
          }, [typeCase.type]);

    useEffect(() => {
      const item = ANH_XA.find(item => item.value === typeCase.type);
        if (item && searchParams.get("type") !== item.value) {
          navigate(`/quan-ly/ky-thi?type=${item.value}`);
        }
    }, [typeCase.type])

    
    const handleReset = () => {
        if (defaultFormRef.current) {
            setFormData(defaultFormRef.current);
        } else {
            setFormData({
              timeStart: "",
              timeEnd: "",
              dateExam: "",
              isAdd: "",
            })
            console.warn("Dữ liệu mặc định chưa được khởi tạo");
        }
    };

    return (
        <section className={`manager-exam ${className}`}>
            <h2>Quản lý kỳ thi</h2>
            <ListTable
              struct={data}
              headers={HEADERS}
              error={error}
            />
            <h4>Chỉnh sửa nhanh:</h4>
            <Dropdown
                name="type"
                id="type"
                choices={ANH_XA}
                value={typeCase.type}
                setFormData={setTypeCase}
                label='Kỳ thi'
            />
            {ANH_XA.some(item => item.value === typeCase.type) && (
              <Card className='form-ky-thi'>
              <form>
                <DatetimePicker
                  type="datetime"
                  name="timeStart"
                  id="timeStart"
                  value={String(formData.timeStart)}
                  setFormData={setFormData}
                  placeholder='Thời gian mở'
                  disabled={statusNum >= 2 || statusNum <= 4}
                  errors={errors}
                  setErrors={setErrors}
                  valids={valids.timeStart}
                />
                <DatetimePicker
                  type="datetime"
                  name="timeEnd"
                  id="timeEnd"
                  value={String(formData.timeEnd)}
                  setFormData={setFormData}
                  placeholder='Thời gian đóng'
                  disabled={statusNum >= 3 && statusNum <= 4}
                  errors={errors}
                  setErrors={setErrors}
                  valids={valids.timeEnd}
                />
                <InputChoice
                  name="isAdd"
                  id="isAdd"
                  choices={[{value: 'true', label: "Bổ sung thí sinh?"}]}
                  value={formData.isAdd}
                  setFormData={setFormData}
                  disabled={statusNum === 2 || statusNum === 4}
                />
                <DatetimePicker
                  type="date"
                  name="dateExam"
                  id="dateExam"
                  value={String(formData.dateExam)}
                  setFormData={setFormData}
                  placeholder='Ngày thi dự kiến'
                  disabled={statusNum === 4}
                  errors={errors}
                  setErrors={setErrors}
                  valids={valids.dateExam}
                />
              </form>
              <div className="button-form">
                    <Button
                        type="button"
                        className="btn-confirm"
                        // onClick={handleSubmit}
                        text="Cập nhật!"
                        disabled={isLoading}
                    />
                    <Button
                        type="button"
                        className="btn-cancel"
                        onClick={handleReset}
                        text="Khôi phục"
                        disabled={isLoading}
                    />
                </div>
              </Card>
            )}
        </section>
    );
}

export default React.memo(ManagerExamContainer);

const NullJsxError = (error:string):JSX.Element => {
  console.log(error);
  return<></>;
}
