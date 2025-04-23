import React from "react";
import { Helmet } from "react-helmet-async";
import IndexBackground from "../../components/layout/IndexBackground";
import MainWarpper from "../../components/layout/MainWarpper";
import Header from "../../components/layout/Header";
import HeroSection from "../../components/feature/home/HeroSection";
import KeyInfomation from "../../components/feature/home/KeyInformation";
import IntroduceSection from "../../components/feature/home/IntroduceSection";
import "./HomePage.scss";

const HomePage = () => {
    return (
        <div>
      <Helmet>
        <title>Web tuyển sinh - Trang chủ</title>
      </Helmet>
      <IndexBackground>
        <Header/>
        <MainWarpper>
          <HeroSection/>
          <KeyInfomation/>
          <IntroduceSection/>
        </MainWarpper>
      </IndexBackground>
    </div>
    );
};

export default HomePage;