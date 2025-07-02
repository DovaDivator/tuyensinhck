import {JSX, useState, useEffect} from "react";
import { useInView } from "react-intersection-observer";
import { useParams, useNavigate, Link} from "react-router-dom";
import { Helmet } from "react-helmet-async";
import InfoBackground from "../../views/ui/layout/InfoBackground";
import HeroSection from "../../views/feature/home/HeroSection";
import "./InfoPage.scss";
import SwitchPasswordForm from "../../views/feature/info/SwitchPasswordForm";
import BaseInfomation from "../../views/feature/info/BaseInfomation";

const CLASS_PAGE = "info";

const InfoPage = (): JSX.Element => {
    const navigate = useNavigate();
    const { type } = useParams();

    const CLASS_PAGES = ['thong-tin-ca-nhan', 'cap-nhat-cccd', 'tra-cuu-ky-thi', 'doi-mat-khau'];
    
    if(!CLASS_PAGES.includes(type || '')) {
        navigate("/");
    }

    const { ref, inView } = useInView({
        triggerOnce: true,
        threshold: 0.2,
    });

    const ANIMATION_CLASS_PHASE = ["hide", "start"];
    const [animationClass, setAnimationClass] = useState(ANIMATION_CLASS_PHASE[0]);

    useEffect(() => {
        if (inView) {
            setAnimationClass(ANIMATION_CLASS_PHASE[1]);
        }
    }, [inView]);

    const LeftMenu = (): JSX.Element =>{
      return(
        <div className="left-menu">
          <ul>
            <li className={type === CLASS_PAGES[0] ? "active" : ""}>
              <Link to="/info/thong-tin-ca-nhan">Thông tin cá nhân</Link>
            </li>
            <li className={type === CLASS_PAGES[1] ? "active" : ""}>
              <Link to="/info/cap-nhat-cccd">Cập nhật CCCD</Link>
            </li>
            <li className={type === CLASS_PAGES[2] ? "active" : ""}>
              <Link to="/info/tra-cuu-ky-thi">Tra cứu kỳ thi</Link>
            </li>
            <li className={type === CLASS_PAGES[3] ? "active" : ""}>
              <Link to="/info/doi-mat-khau">Thay đổi mật khẩu</Link>
            </li>
          </ul>
        </div>
      )
    }

    const RightContent = (): JSX.Element =>{
      switch(type){
        case CLASS_PAGES[0]:
          return(<><BaseInfomation/></>);
        case CLASS_PAGES[3]:
          return(<><SwitchPasswordForm/></>);
        default:
          return(<></>);
      }
    }

    return (
        <div>
      <Helmet>
        <title>Cá nhân - Web tuyển sinh</title>
      </Helmet>
      <InfoBackground>
          <LeftMenu/>
          <div ref={ref} className={animationClass}>
            <RightContent/>
          </div>
      </InfoBackground>
    </div>
    );
};

export default InfoPage;