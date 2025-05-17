import { JSX } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Helmet } from 'react-helmet-async';

import IndexBackground from '../../views/ui/layout/IndexBackground';
import IntroduceHe from '../../views/feature/discover-nganh/IntroduceHe';
import ListTopNganh from '../../views/feature/home/ListTopNganh';
import BoDemLichThi from '../../views/feature/discover-nganh/BoDemLichThi';

import "./DiscoverUniPage.scss";


const DiscoverUniPage = (): JSX.Element => {
    const navigate = useNavigate();
    const { type } = useParams();

    let name:string = "";

    /**
     * Điều phối trang và gắn giá trị hiển thị
     */
    const getPageInfo = ({type = ""}: {type?: string}): void =>{
        switch(type){
            case 'dai-hoc':
                name = "đại học";
                break;
            case 'cao-dang':
                name = "cao đẳng";
                break;
            case 'lien-thong':
                name = "lien-thong";
                break;
            default:
                navigate("/");
        }
    }
    getPageInfo({type});

  return (
      <div>
      <Helmet>
        <title>Web tuyển sinh - Tổng quan hệ {name}</title>
      </Helmet>
      <IndexBackground>
            <IntroduceHe type={type}/>    
            <ListTopNganh/>
            <BoDemLichThi type={type}/>
      </IndexBackground>
    </div>
    );
};

export default DiscoverUniPage;
