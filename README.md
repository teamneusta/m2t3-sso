# Work in Progress - M2T3 - TYPO3 Magento Single Sign On

## Requirements

- php 7
- TYPO3 > 8.2
- team-neusta-gmbh/m2t3-elastictypo

## Explaination

- Import Magento groups to TYPO3 groups
- Import Magento categories to TYPO3 pages

## Installation

- add following to your composer.json

```javascript
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/teamneusta/m2t3-sso.git"
    }
  ],
  "require": {
    "TeamNeustaGmbH/m2t3-sso": "^1.0"
  }
}
```

- after that make an `composer update`  

## Configuration

- Needed Configuration for AdditionalConfiguration
```
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO']['url'] = 'http://magento/userExample.json';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO']['cookieName'] = 'frontend';
```

Explain: for SSO

| option | description | example
| ------------ | ------------- | -------------
| url | url to login service for M2T3 | http://****
| cookieName | magento cookie name | frontend

### Usage

defaulty worked without more configuration
