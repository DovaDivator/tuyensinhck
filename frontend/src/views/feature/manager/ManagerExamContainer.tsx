import React,{JSX, useState, useEffect} from 'react';
import { parsePath, useLocation, useSearchParams} from "react-router-dom";
import { useAuth } from '../../../context/AuthContext';

import { jsxEleProps } from '../../../types/jsxElementInterfaces';
import './ManagerUserList.scss';
import ListTable from '../../ui/components/ListTable';
import InputField from '../../ui/input/InputField';
import { FormDataProps} from '../../../types/FormInterfaces';
import InputChoice from '../../ui/input/InputChoice';
import { ChoiceGroup } from '../../../classes/ChoiceGroup';
import Button from '../../ui/input/Button';
import Pagination from '../../ui/components/Pagination';
import Dropdown from '../../ui/input/Dropdown';
import { useAppContext } from '../../../context/AppContext';
import { fetchUsers, fetchUsersPagination, fetchUsersDropdownItems} from '../../../api/fetchUser';
import * as editFunc from '../../../function/convert/AdminDataConvertEdit';

const HEADERS = {
    loai_thi: "Cấp bậc",
    khoa: "Khóa thi",
    time_start: "Thời gian mở",
    time_end: "Thời gian đóng",
    date_exam: "Ngày tổ chức",
    status: "Tình trạng",
}
const ANH_XA = [
    {value: "hd", label: "Đại học"},
    {value: "cd", label: "Cao đẳng"},
    {value: "lt", label: "Liên thông"}
];

const ManagerExamContainer = ({className = ""}: jsxEleProps): JSX.Element =>{
    const {token} = useAuth();
    const [error, setError] = useState<string>("");
    const [typeCase, setTypeCase] = useState<any>({type: ""});

    return (
        <section className={`manager-exam ${className}`}>
            <h2>Quản lý kỳ thi</h2>
            <ListTable
              struct={[]
              }
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
        </section>
    );
}

export default React.memo(ManagerExamContainer);

const NullJsxError = (error:string):JSX.Element => {
  console.log(error);
  return<></>;
}
