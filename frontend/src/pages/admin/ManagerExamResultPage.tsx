import { JSX, useEffect, useState, useRef } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Helmet } from 'react-helmet-async';
import { useSearchParams } from 'react-router-dom';

import IndexBackground from '../../views/ui/layout/IndexBackground';

import "./ManagerExamResultPage.scss";
import { useAppContext } from '../../context/AppContext';
import { useAuth } from '../../context/AuthContext';
import { FormDataProps } from '../../types/FormInterfaces';
import Dropdown from '../../views/ui/input/Dropdown';
import InputField from '../../views/ui/input/InputField';
import Button from '../../views/ui/input/Button';
import ListTable from '../../views/ui/components/ListTable';
import Pagination from '../../views/ui/components/Pagination';
import { ChoiceOption } from '../../classes/ChoiceGroup';
import {getListMonGrading } from '../../api/GetMonHoc';
import { GetListTS } from '../../api/GradingMgr';

const ManagerExamResultPage = (): JSX.Element => {
  return (
      <div>
      <Helmet>
        <title>Chấm điểm - Web tuyển sinh</title>
      </Helmet>
      <IndexBackground>
        <ManagerExamResultBody/>         
      </IndexBackground>
    </div>
    );
};

export default ManagerExamResultPage;

const ANH_XA = [
    {value: "dh", label: "Đại học"},
    {value: "cd", label: "Cao đẳng"},
    {value: "lt", label: "Liên thông"}
];

const HEADERS = {
    examId: "Mã thí sinh",
    maPhong: "Mã phòng",
    monThi: "Môn thi",
    diem: "Điểm",
}

const ManagerExamResultBody = (): JSX.Element => {
    const {user, token} = useAuth();
    const {setIsLoading, isLoading} = useAppContext();

    const [listMonThi, setListMonThi] = useState<ChoiceOption[]>([]);
    const [isAllowed, setIsAllowed] = useState<boolean>(true);

    const [callData, setCallData] = useState<boolean>(true);
    const [dataError, setDataError] = useState<string>("");

    const dataRef = useRef<Object[]>([]);
    const [data, setData] = useState<Object[]>([]);

        // if(!(user.isAdmin() || user.isTeacher())) return <></>;
    const [typeCase, setTypeCase] = useState<FormDataProps>({
        he: "dh",
        khoa: "",
        monThi: "",
        search: "",
        phong: "",
    });
    const navigate = useNavigate();

    const [searchParams] = useSearchParams();
    useEffect(() => {
      const heUrl = searchParams.get("he") || "dh";
      const khoaUrl = searchParams.get("khoa") || "";
      const monThiUrl = searchParams.get("monThi") || "";
      const searchUrl = searchParams.get("search") || "";
      const phongUrl = searchParams.get("phong") || "";
      setTypeCase({
        he: heUrl,
        khoa: khoaUrl,
        monThi: monThiUrl,
        search: searchUrl,
        phong: phongUrl,
    });
    }, [searchParams]);

    useEffect(() => {
      const fetchGradingData = async () => {
        try {
          const result = await getListMonGrading(token);
          console.log(result);
          setListMonThi(result.data);
          setTypeCase(prev => ({
            ...prev,
            monThi: result.data.length > 0 ? result.data[0].value : ""
          }));
          } catch (err) {
            console.error(err);
          }
      }

      if(token) fetchGradingData();
    },[])

    useEffect(() => {
      let isAccept = false
      let linkUrl = `/cham-diem?`;

      const itemHe = ANH_XA.find(item => item.value === typeCase.he);
      if (itemHe && searchParams.get("type") !== itemHe.value) {
        isAccept = true;
        linkUrl += `he=${itemHe.value}&`;
      }

      if(String(typeCase.khoa).trim() !== "" && !isNaN(Number(typeCase.khoa))){
        isAccept = true;
        linkUrl += `khoa=${typeCase.khoa}&`;
      }

      if(listMonThi.length > 0){
        const itemMonThi = listMonThi.find(item => item.value === typeCase.monThi);
        if (itemMonThi && searchParams.get("type") !== itemMonThi.value) {
          isAccept = true;
          linkUrl += `monThi=${itemMonThi.value}`;
        }
      }

      if(isAccept){ 
        setCallData(true);
        navigate(linkUrl);
      }
    }, [typeCase.he, typeCase.khoa, typeCase.monThi])

    useEffect(() => {
      const fetchData = async () => {
        setIsLoading(true);
        setDataError("");
        try {
          const result = await GetListTS(token, {
            he: typeCase.he,
            khoa: typeCase.khoa,
            monThi: typeCase.monThi
          });

          console.log(result);

          if (!result.data || Object.keys(result.data).length === 0 || !result.data.list) {
            dataRef.current = [];
          }else{
            dataRef.current = result.data.list;
          }

          setData(dataRef.current);
        } catch (error) {
          console.error(error);
          setDataError("Có sự cố xảy ra");
        } finally {
          setIsLoading(false);
        }
      }

      if(callData){
        fetchData();
        setCallData(false);
      }
    }, [callData])

  return (
        <div className='manager-exam-result-body'>
            <section className='manager-exam-result-header'>
                <h2 className='title'>Chấm điểm</h2>
                <p className='description'>Vui lòng chọn kỳ thi và môn thi để chấm!</p>
                <form>
                  <div className='dropdown-grid'>
                    <Dropdown
                        name="he"
                        id="he"
                        choices={ANH_XA}
                        value={String(typeCase.he)}
                        setFormData={setTypeCase}
                        label='Kỳ thi'
                    />
                    <InputField
                        type='number'
                        id="khoa"
                        name= "khoa"
                        value={typeCase.khoa}
                        formData={typeCase}
                        setFormData={setTypeCase}
                        placeholder='khoa'
                    />
                    <Dropdown
                        name="monThi"
                        id="monThi"
                        choices={listMonThi}
                        value={String(typeCase.monThi)}
                        setFormData={setTypeCase}
                        label='môn thi'
                    />
                  </div>
                  <InputField
                    name="search"
                    id="search"
                    placeholder='Tìm kiếm'
                    value={typeCase.search}
                    maxLength={70}
                    formData={typeCase}
                    setFormData={setTypeCase}
                  />
                  <Dropdown
                    name="phong"
                    id="phong"
                    choices={ANH_XA}
                    value={String(typeCase.phong)}
                    setFormData={setTypeCase}
                    label='Phòng thi'
                    allowDefault={true}
                  />
                </form>
                <div className="button-form">
                    <Button
                        type="button"
                        className="btn-confirm"
                        // onClick={handleStartSubmit}
                        text="Cập nhật!"
                        disabled={isLoading}
                    />
                    <Button
                        type="button"
                        className="btn-cancel"
                        // onClick={handleStartReset}
                        text="Khôi phục"
                        disabled={isLoading}
                    />
                </div>
            </section>
            
            <section className='manager-exam-result-content'>
                <ListTable
                  struct={data}
                  headers={HEADERS}
                  error={dataError}
                />
                <Pagination/>
            </section>
        </div>
    );
};
