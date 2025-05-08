import {JSX} from "react";
import { Helmet } from "react-helmet-async";
import IndexBackground from "../../views/ui/layout/IndexBackground";
import HeroSection from "../../views/feature/home/HeroSection";
import KeyInfomation from "../../views/feature/home/KeyInformation";
import IntroduceSection from "../../views/feature/introduce/IntroduceSection";
import NewsSection from "../../views/feature/home/NewsSection";
import ListTopNganh from "../../views/feature/home/ListTopNganh";
import OutstadingStuSection from "../../views/feature/home/OutstadingStuSection";
import "./HomePage.scss";

const HomePage = (): JSX.Element => {
    return (
        <div>
      <Helmet>
        <title>Web tuyển sinh - Trang chủ</title>
      </Helmet>
      <IndexBackground>
          <HeroSection/>
          <IntroduceSection/>
          <KeyInfomation/>
          <ListTopNganh/>
          <NewsSection/>
          <OutstadingStuSection/>
      </IndexBackground>
    </div>
    );
};

export default HomePage;