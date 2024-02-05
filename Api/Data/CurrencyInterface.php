<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\Currency\Api\Data;

interface CurrencyInterface
{
    /**
     * String constants for property names
     */
    const ENTITY_ID = "entity_id";
    const CODE = "code";
    const STATUS = "status";
    const SYMBOL = "symbol";
    const PRECISION = "precision";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";
    const NAME = "name";
    const FORMAT_PRECISION = "format_precision";
    const PLURAL = "plural";
    const FORMAT = "format";
    const FORMAT_HTML = "format_html";
    const SYMBOL_HTML = "symbol_html";

    const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 0;

    /**
     * Identifier getter
     *
     * @return mixed
     */
    public function getId();

    /**
     * Identifier setter
     *
     * @param mixed $value
     * @return $this
     */
    public function setId($value);

    /**
     * Getter for Code.
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * Setter for Code.
     *
     * @param string $code
     * @return self
     */
    public function setCode(string $code): self;

    /**
     * Getter for Symbol.
     * @return string|null
     */
    public function getSymbol(): ?string;

    /**
     * Setter for Symbol.
     *
     * @param string $symbol
     * @return self
     */
    public function setSymbol(string $symbol): self;

    /**
     * Getter for Precision.
     * @return string|null
     */
    public function getPrecision(): ?int;

    /**
     * Setter for Precision.
     *
     * @param int $precision
     * @return self
     */
    public function setPrecision(int $precision): self;

    /**
     * Getter for CreatedAt.
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Setter for CreatedAt.
     *
     * @param string $createdAt
     * @return self
     */
    public function setCreatedAt(string $createdAt): self;

    /**
     * Getter for UpdatedAt.
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Setter for UpdatedAt.
     *
     * @param string $updatedAt
     * @return self
     */
    public function setUpdatedAt(string $updatedAt): self;

    /**
     * Getter for Name.
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self;

    /**
     * Getter for Format Precision.
     * @return string|null
     */
    public function getFormatPrecision(): ?string;

    /**
     * Setter for Format Precision.
     *
     * @param string $formatPrecision
     * @return self
     */
    public function setFormatPrecision(string $formatPrecision): self;

    /**
     * Getter for Plural.
     * @return string|null
     */
    public function getPlural(): ?string;

    /**
     * Setter for Plural.
     *
     * @param string $plural
     * @return self
     */
    public function setPlural(string $plural): self;

    /**
     * Getter for Format.
     * @return string|null
     */
    public function getFormat(): ?string;

    /**
     * Setter for Format.
     *
     * @param string $format
     * @return self
     */
    public function setFormat(string $format): self;

    /**
     * Getter for Format Html.
     * @return string|null
     */
    public function getFormatHtml(): ?string;

    /**
     * Setter for Format Html.
     *
     * @param string $formatHtml
     * @return self
     */
    public function setFormatHtml(string $formatHtml): self;

    /**
     * Getter for Status.
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Setter for Status.
     *
     * @param int $status
     * @return self
     */
    public function setStatus(int $status): self;

    /**
     * Getter for Symbol Html.
     * @return string|null
     */
    public function getSymbolHtml(): ?string;

    /**
     * Setter for Symbol Html.
     *
     * @param string $symbolHtml
     * @return self
     */
    public function setSymbolHtml(string $symbolHtml): self;
}
