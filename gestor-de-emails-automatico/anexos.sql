create table anexos
(
    id         bigint unsigned auto_increment
        primary key,
    user_id    bigint unsigned not null,
    nome       varchar(255)    not null,
    hashname   varchar(255)    not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint anexos_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

