# Changelog

## [v0.15.0](https://github.com/msgphp/domain/tree/v0.15.0) (2020-02-25)

- Update Symfony dependencies to allow 5.0 packages [\#379](https://github.com/msgphp/msgphp/pull/379)


## [v0.12.0](https://github.com/msgphp/domain/tree/v0.12.0) (2019-07-21)

- Removed \*Exception type suffix [\#346](https://github.com/msgphp/msgphp/pull/346)
- Move DomainMessageBus to root [\#345](https://github.com/msgphp/msgphp/pull/345)
- \[BC break\] Support Elasticsearch 7 [\#344](https://github.com/msgphp/msgphp/pull/344)
- Removed "msgphp.messenger.console\_message\_receiver" service [\#340](https://github.com/msgphp/msgphp/pull/340)


## [v0.11.0](https://github.com/msgphp/domain/tree/v0.11.0) (2019-07-13)

- mark DomainId::\_\_toString internal, rename Username::\_\_toString to toString [\#324](https://github.com/msgphp/msgphp/pull/324)
- Rename EventSourcingCommandHandlerTrait::handle\(\) to handleEvent\(\) [\#317](https://github.com/msgphp/msgphp/pull/317)
- Use "on...Event\(\)" method convention in DomainEventHandlerTrait [\#314](https://github.com/msgphp/msgphp/pull/314)


## [v0.10.0](https://github.com/msgphp/domain/tree/v0.10.0) (2019-03-27)

- Removed type suffixes [\#310](https://github.com/msgphp/msgphp/pull/310)
- Renamed Infra\ to Infrastructure\ [\#309](https://github.com/msgphp/msgphp/pull/309)
- Rename Entity\{Fields,Features}\ to Model\ [\#301](https://github.com/msgphp/msgphp/pull/301)
- Renamed PaginatedDomainCollection to GenericPaginatedDomainCollection [\#300](https://github.com/msgphp/msgphp/pull/300)
- Renamed DomainCollection to GenericDomainCollection [\#299](https://github.com/msgphp/msgphp/pull/299)
- Renamed EventSourcingCommandHandlerTrait::getDomainEventHandler\(\) to getDomainEventTarget\(\) [\#296](https://github.com/msgphp/msgphp/pull/296)
- Rename DomainObjectFactory to GenericDomainObjectFactory [\#295](https://github.com/msgphp/msgphp/pull/295)
- Renamed Command\EventSourcingCommandHandlerTrait to Event\, removed UnexpectedDomainEventException [\#291](https://github.com/msgphp/msgphp/pull/291)
- Rename Event\\*Projection\* to Projection\Event\ [\#290](https://github.com/msgphp/msgphp/pull/290)
- Rename Command\\*Projection\* to Projection\Command\ [\#289](https://github.com/msgphp/msgphp/pull/289)
- Remove EnabledField in favor of CanBeEnabled [\#288](https://github.com/msgphp/msgphp/pull/288)
- mark Infra\Doctrine\DomainIdType an abstract [\#287](https://github.com/msgphp/msgphp/pull/287)
- Nuke abstract DomainId in favor of a trait [\#284](https://github.com/msgphp/msgphp/pull/284)


## [v0.9.1](https://github.com/msgphp/domain/tree/v0.9.1) (2019-02-20)

- disallow empty string ID values [\#281](https://github.com/msgphp/msgphp/pull/281)


## [v0.9.0](https://github.com/msgphp/domain/tree/v0.9.0) (2019-02-09)

- cleanup serialization [\#279](https://github.com/msgphp/msgphp/pull/279)
- Remove DomainIdentityMappingInterface +  DomainIdentityHelper [\#276](https://github.com/msgphp/msgphp/pull/276)
- Remove EntityAwareFactoryInterface [\#274](https://github.com/msgphp/msgphp/pull/274)
- Remove EntityAwareFactoryInterface::identify\(\) [\#273](https://github.com/msgphp/msgphp/pull/273)
- Remove EntityAwareFactoryInterface::nextIdentifier\(\) [\#272](https://github.com/msgphp/msgphp/pull/272)
- Remove entity to identifier mapping [\#271](https://github.com/msgphp/msgphp/pull/271)
- Normalize object arguments in factory context [\#270](https://github.com/msgphp/msgphp/pull/270)
- \[BC-BREAK\] Require expected ID type in domain commands [\#269](https://github.com/msgphp/msgphp/pull/269)
- remove DomainCollectionFactory [\#268](https://github.com/msgphp/msgphp/pull/268)
- remove unused DomainIdFactory [\#267](https://github.com/msgphp/msgphp/pull/267)
- Drop SimpleBus support [\#260](https://github.com/msgphp/msgphp/pull/260)
- Drop GLOB\_BRACE dependency [\#259](https://github.com/msgphp/msgphp/pull/259)
- Rename GlobalObjectMemory to DomainIdentityMap [\#258](https://github.com/msgphp/msgphp/pull/258)
- re-identity DomainIdInterface in EntityAwareFactory::identify\(\) [\#252](https://github.com/msgphp/msgphp/pull/252)
- cleanup DomainIdentityHelper/Mapping [\#251](https://github.com/msgphp/msgphp/pull/251)
- auto-detect entity-alias in doctrine repository [\#246](https://github.com/msgphp/msgphp/pull/246)


## [v0.8.0](https://github.com/msgphp/domain/tree/v0.8.0) (2018-12-01)

- create lazy entity references [\#230](https://github.com/msgphp/msgphp/pull/230)
- revise collection api [\#223](https://github.com/msgphp/msgphp/pull/223)
- Use strict array comparison [\#220](https://github.com/msgphp/msgphp/pull/220)
- \[BC Break\] Make DomainCollectionInterface::map\(\) returns an instance of self [\#219](https://github.com/msgphp/msgphp/pull/219)
- Turn DomainCollection's filter & slice functions into lazy functions [\#218](https://github.com/msgphp/msgphp/pull/218)
- update symfony/messenger [\#215](https://github.com/msgphp/msgphp/pull/215)
