from ibm_watson import DiscoveryV1
from ibm_cloud_sdk_core.authenticators import IAMAuthenticator

api_key = '<your api key>'
environment_id = '<environment_id>'
collection_id = '<collection_id>'

authenticator = IAMAuthenticator(api_key)
discovery = DiscoveryV1(
    version='2018-08-01',
    authenticator=authenticator)
discovery.set_service_url('https://gateway.watsonplatform.net/discovery/api')

query_results = discovery.query(
  environment_id,
  collection_id,
  text='copyright').get_result()
  
docs = query_results['results']
for doc in docs:
  discovery.delete_document(
    environment_id,
    collection_id,
    doc["id"]
  )