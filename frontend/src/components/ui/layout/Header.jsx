import React, {useContext} from "react";
import { Link, useNavigate } from "react-router-dom";
import { AppContext } from '../../../context/AppContext';

import logoNormal from "../../../assets/images/logo-01.png";
import logoSmall from "../../../assets/images/logo_small.png";

import Button from "../input/Button";
import "./Header.scss";

const Header = () => {
    const { screenSize } = useContext(AppContext);
    const navigate = useNavigate();

    return (
        <header className="header">
        <figure className="header__logo" title="Quay về trang chủ">
            <Link to="/home" className="header__logo-link">
                <img src={screenSize.width < 768 ? logoSmall : logoNormal} alt="Logo" className="header__logo-img" />
            </Link>
        </figure>
        <nav className="header__nav">
            <ul className="header__nav-list">
                <li className="header__nav-item">
                    <Link to="/">a</Link>
                </li>
                <li className="header__nav-item">
                    <Link to="/about">b</Link>
                </li>
                <li className="header__nav-item">
                    <Link to="/contact">c</Link>
                </li>
            </ul>
            <div className="user-action">
                <Button
                    text={screenSize.width < 768 ? "" : "Đăng nhập"}
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