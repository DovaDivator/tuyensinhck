import React from "react";
import { Helmet } from "react-helmet-async";
import IndexBackground from "../../components/ui/layout/IndexBackground";
import MainWarpper from "../../components/ui/layout/MainWarpper";
import Header from "../../components/ui/layout/Header";
import HeroSection from "../../components/feature/home/HeroSection";
import KeyInfomation from "../../components/feature/home/KeyInformation";
import IntroduceSection from "../../components/feature/home/IntroduceSection";
import NewsSection from "../../components/feature/home/NewsSection";
import ListTopNganh from "../../components/feature/home/ListTopNganh";
import OutstadingStuSection from "../../components/feature/home/OutstadingStuSection";
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
          <IntroduceSection/>
          <KeyInfomation/>
          <ListTopNganh/>
          <NewsSection/>
          <OutstadingStuSection/>
        </MainWarpper>
      </IndexBackground>
    </div>
    );
};

export default HomePage;