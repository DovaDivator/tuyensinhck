import { JSX } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Helmet } from 'react-helmet-async';

import IndexBackground from '../../views/ui/layout/IndexBackground';
import ManagerUserList from '../../views/feature/manager/ManagerUserList';

import "./ManagerUserPage.scss";

const ManagerUserPage = (): JSX.Element => {
    const navigate = useNavigate();
    const { type } = useParams();

    const CLASS_PAGES = ['giao-vien', 'thi-sinh', 'tai-khoan'];
    let name:string = "";

    /**
     * Điều phối trang và gắn giá trị hiển thị
     */
    const getPageInfo = ({type = ""}: {type?: string}): void =>{
        switch(type){
            case CLASS_PAGES[0]:
                name = "giáo viên";
                break;
            case CLASS_PAGES[1]:
                name = "thí sinh";
                break;
            case CLASS_PAGES[2]:
                name = "tài khoản";
                break;
            default:
                console.error("lỗi url " + type);
                navigate("/");
        }
    }
    getPageInfo({type});

  return (
      <div>
      <Helmet>
        <title>Quản lý {name} - Web tuyển sinh</title>
      </Helmet>
      <IndexBackground>
        <ManagerUserList name={name}/>         
      </IndexBackground>
    </div>
    );
};

export default ManagerUserPage;
