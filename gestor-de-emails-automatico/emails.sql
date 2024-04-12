create table emails
(
    id         bigint unsigned auto_increment
        primary key,
    user_id    bigint unsigned not null,
    email      varchar(255)    not null,
    descricao  varchar(255)    null,
    created_at timestamp       null,
    updated_at timestamp       null,
    constraint emails_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

