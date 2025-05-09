import {JSX, ReactNode,  useContext} from "react";
import { Link, useNavigate } from "react-router-dom";
import { AppContext } from '../../../context/AppContext';

import logoNormal from "../../../assets/images/logo-01.png";
import logoSmall from "../../../assets/images/logo_small.png";

import Button from "../input/Button";
import "./Header.scss";

const Header = (): JSX.Element => {
    const SWITCH_UI_WIDTH = 900;
    const SMALL_MENU_NAV = 480;
    const { screenSize } = useContext(AppContext);
    const navigate = useNavigate();

    const SmallMenu = ({ children }: { children: React.ReactNode }): ReactNode => {
        if (screenSize.width < SMALL_MENU_NAV) {
            return (
                <>
                <li className="header__nav-item">
                    <a>Menu</a>
                    <ul className="submenu">
                        {children}
                    </ul>
                </li>
                </>
            );
        } else {
            return <>{children}</>;
        }
    };

    return (
        <header className="header">
            <figure className="header__logo" title="Quay về trang chủ">
                <Link to="/home" className="header__logo-link">
                    <img src={screenSize.width < SWITCH_UI_WIDTH ? logoSmall : logoNormal} alt="Logo" className="header__logo-img" />
                </Link>
            </figure>
            <nav className="header__nav">
                <ul className="header__nav-list">
                        <SmallMenu>
                            <li>
                                <a>Nhà trường</a>
                                <ul className={`submenu${screenSize.width < SMALL_MENU_NAV ? "_r2" : ""}`}>
                                    <li><a href="/introduce">Giới thiệu</a></li>
                                    <li><a href="#">Tin tức</a></li>
                                </ul>
                            </li>
                            <li>
                                <a>Thi tuyển</a>
                                <ul className={`submenu${screenSize.width < SMALL_MENU_NAV ? "_r2" : ""}`}>
                                    <li><a href="#">Thể lệ</a></li>
                                    <li><a href="#">Tra cứu</a></li>
                                    <li><a href="#">Đăng ký thi</a></li>
                                </ul>
                            </li>
                            <li>
                                <a>Chuyên ngành</a>
                                <ul className={`submenu${screenSize.width < SMALL_MENU_NAV ? "_r2" : ""}`}>
                                    <li><a href="#">Các ngành HOT</a></li>
                                    <li><a href="#">Các ngành KHTN</a></li>
                                    <li><a href="#">Các ngành KHXH</a></li>
                                    <li><a href="#">Tìm kiếm nâng cao</a></li>
                                </ul>
                            </li>
                            <li>
                                <a>Dịch vụ</a>
                                <ul className={`submenu${screenSize.width < SMALL_MENU_NAV ? "_r2" : ""}`}>
                                    <li><a href="#">Điều khoảng dịch vụ</a></li>
                                    <li><a href="#">Hỏi đáp</a></li>
                                    <li><a href="#">Hỗ trợ</a></li>
                                    <li><a href="#">Về chúng tôi</a></li>
                                </ul>
                            </li>
                        </SmallMenu>
                </ul>
                <div className="user-action">
                    <Button
                        text={screenSize.width < SWITCH_UI_WIDTH ? "" : "Đăng nhập"}
                        icon={"fa-solid fa-circle-user"}
                        className="user-action__login-btn"
                        onClick={() => navigate('/login')}
                    />
                </div>
            </nav>
        </header>
    );
};

export default Header;