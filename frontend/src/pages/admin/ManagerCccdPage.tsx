import { JSX } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Helmet } from 'react-helmet-async';

import IndexBackground from '../../views/ui/layout/IndexBackground';
import ManagerCccdContainer from '../../views/feature/manager/ManagerCccdContainer';

import "./ManagerUserPage.scss";

const ManagerCccdPage = (): JSX.Element => {

  return (
      <div>
      <Helmet>
        <title>Quản lý dữ liệu CCCD</title>
      </Helmet>
      <IndexBackground>
          <ManagerCccdContainer/>
      </IndexBackground>
    </div>
    );
};

export default ManagerCccdPage;