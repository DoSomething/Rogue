import React from 'react';
import gql from 'graphql-tag';
import { useQuery } from '@apollo/react-hooks';

const GROUP_TYPE_CAMPAIGN_LIST_QUERY = gql`
  query GroupTypeCampaignListQuery($groupTypeId: Int!) {
    paginatedCampaigns(groupTypeId: $groupTypeId) {
      edges {
        node {
          id
          internalTitle
        }
      }
    }
  }
`;

const GroupTypeCampaignList = ({ groupTypeId }) => {
  const { loading, error, data } = useQuery(GROUP_TYPE_CAMPAIGN_LIST_QUERY, {
    variables: { groupTypeId },
  });

  if (loading) {
    return <>...</>;
  }

  if (error) {
    return <>{JSON.stringify(error)}</>;
  }
  console.log(data);

  if (!data.paginatedCampaigns || !data.paginatedCampaigns.edges) {
    return <>--</>;
  }

  return (
    <>
      {data.paginatedCampaigns.edges.map(item => (
        <a key={item.node.id} href={`/campaigns/${item.node.id}`}>
          {item.node.internalTitle}
        </a>
      ))}
    </>
  );
};

export default GroupTypeCampaignList;
