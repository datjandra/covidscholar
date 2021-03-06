# CovidScholar

[![License](https://img.shields.io/badge/License-Apache2-blue.svg)](https://www.apache.org/licenses/LICENSE-2.0) [![Slack](https://img.shields.io/badge/Join-Slack-blue)](https://callforcode.org/slack) [![Website](https://covid19scholar.herokuapp.com)

## Contents

1. [Short description](#short-description)
1. [Demo video](#demo-video)
1. [The architecture](#the-architecture)
1. [Project roadmap](#project-roadmap)
1. [Getting started](#getting-started)
1. [Live demo](#live-demo)
1. [Built with](#built-with)
1. [Versioning](#versioning)
1. [Authors](#authors)
1. [License](#license)
1. [Acknowledgments](#acknowledgments)

## Short description

### What's the problem?

Communication during a crisis is critical for keeping people and organizations informed about unfolding events, available resources, and coordinated activities. The success of crisis management depends on accurate and up to date information from trusted sources. In modern age access to information is not an issue - instead, there is an information overload that takes a lot of time and effort in order to find a short and accurate answer one is looking for. How do we find answers to similar questions that have different meanings depending on the context and intent of the question?

### How can technology help?

A smart crisis communication Chatbot can help with important questions that have almost unique well-defined answers. It can also provide access to a credible knowledge base collection from which AI systems can draw answers and could learn from the overall Q&A process. However, a Chatbot interface is not suitable for follow-up in-depth refining search. Furthermore, training a chatbot may be biassed by the programmer's own way of posing questions.

### The idea

Utilizing a web-page interface to answer COVID-19 related questions by experts and the general public with clear intent and context can help build a knowledge datasets with proper focus and continuously improving the training of an AI system. The answers to the most frequent questions within each sub-category will be built into a Watson Assistant Chatbot with a relevant intent while the less frequent questions will be addressed by the Watson Discovery AI engine.

## Demo video

[![Watch the video](https://github.com/datjandra/covidscholar/blob/master/mq2.jpg)](https://youtu.be/E4vbUMMKdAY)

## The architecture

![CovidScholar Architecture](https://github.com/datjandra/covidscholar/blob/master/CovidScholar%20Architecture.png)

1. The user navigates to the *CovidScholar* web site to pose questions and to interact with the frontend.
2. Based on the selected knowledge database a list of answers is generated by the Watson Discovery engine.
3. The user is presented with the best possible answers along with relevant classification labels related to concepts and entities.
4. The subsequent user behavior informs the AI on the relevance of the answers obtained.
5. The queries and answers are recorded and utilized for continuous AI training.


Post-processing: The most frequent questions with clear unique answers are grouped into similarity sets and utilized via a Watson Assistant Chatbot for broader access and dissemination.

## Project roadmap

1. Collect user queries with web-interface.

2. Build trusted search collections.

3. Train and Improve Watson Discovery AI engines.

4. Deploy Improved Watson Assistant ChatBot.


## Getting started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

You will need Watson Discovery and NLU instances.

### Configuring PHP services

Configure query.php with API key and IDs as shown below.

```
define("COLLECTION_ID", "<YOUR COLLECTION ID>");

define("ENVIRONMENT_ID", "<YOUR ENVIRONMENT ID>");

$url = "https://api.us-south.natural-language-understanding.watson.cloud.ibm.com/instances/<YOUR NLU INSTANCE>/v1/analyze?version=2019-07-12";

curl_setopt($curl, CURLOPT_USERPWD, "<YOUR API KEY>");
```

Configure news.php with API key and ID for Watson News collection as shown below.

```
define("ENVIRONMENT_ID", "<YOUR ENVIRONMENT_ID>");

curl_setopt($curl, CURLOPT_USERPWD, "<YOUR API KEY>");
```

## Live demo

You can find a running system to test at [Biosight](https://marketengine.parts/biosight)

## Built with

* [Watson Discovery](https://www.ibm.com/cloud/watson-discovery) - Cognitive search engine
* [Watson NLU](https://www.ibm.com/cloud/watson-natural-language-understanding) - Text analytics engine
* [Watson Knowledge Studio](https://www.ibm.com/cloud/watson-knowledge-studio) - Domain-specific knowledge graph models
* [Watson Assistant](https://www.ibm.com/cloud/watson-assistant-2/) - Conversational interface platform

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags).

## Authors

* **Billie Thompson** - *Initial work* - [PurpleBooth](https://github.com/PurpleBooth)

See also the list of [contributors](https://github.com/Code-and-Response/Project-Sample/graphs/contributors) who participated in this project.

## License

This project is licensed under the Apache 2 License - see the [LICENSE](LICENSE) file for details

## Acknowledgments

* Based on [Billie Thompson's README template](https://gist.github.com/PurpleBooth/109311bb0361f32d87a2).
