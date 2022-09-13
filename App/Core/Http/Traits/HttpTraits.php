<?php

declare(strict_types=1);

trait HttpTraits
{
    /**
     * Get the value of httpServer.
     */
    public function server(): CollectionInterface
    {
        return $this->server;
    }

    /**
     * Set the value of httpServer.
     */
    public function setServer(CollectionInterface $httpServer): self
    {
        $this->server = $httpServer;
        return $this;
    }

    /**
     * Get the value of httpFiles.
     */
    public function getHttpFiles(): CollectionInterface
    {
        return $this->httpFiles;
    }

    /**
     * Set the value of httpFiles.
     */
    public function setHttpFiles(CollectionInterface $httpFiles): self
    {
        $this->httpFiles = $httpFiles;

        return $this;
    }

    /**
     * Set the value of method.
     */
    public function setMethod(HttpMethod $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get the value of protocol.
     */
    public function getProtocol(): ?string
    {
        return $this->protocol;
    }

    /**
     * Set the value of protocol.
     */
    public function setProtocol(?string $protocol): self
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * Get the value of requestUri.
     */
    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    /**
     * Set the value of requestUri.
     */
    public function setRequestUri(string $requestUri): self
    {
        $this->requestUri = $requestUri;

        return $this;
    }

    /**
     * Get the value of requestStartTime.
     */
    public function getRequestStartTime(): float
    {
        return $this->requestStartTime;
    }

    /**
     * Set the value of requestStartTime.
     */
    public function setRequestStartTime(float $requestStartTime): self
    {
        $this->requestStartTime = $requestStartTime;

        return $this;
    }

    /**
     * Get the value of rawContent.
     */
    public function getRawContent(): ?string
    {
        if (!$this->rawContent) {
            $this->rawContent = file_get_contents('php://input');
        }

        return $this->rawContent;
    }

    /**
     * Set the value of rawContent.
     */
    public function setRawContent(?string $rawContent): self
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    /**
     * Get the value of query.
     */
    public function getQuery(): CollectionInterface
    {
        return $this->query;
    }

    /**
     * Set the value of query.
     */
    public function setQuery(CollectionInterface $query): self
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Set the value of post.
     */
    public function setPost(CollectionInterface $post): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get the value of cookies.
     */
    public function getCookies(): CollectionInterface
    {
        return $this->cookies;
    }

    /**
     * Set the value of cookies.
     */
    public function setCookies(CollectionInterface $cookies): self
    {
        $this->cookies = $cookies;

        return $this;
    }

    /**
     * Get the value of headers.
     */
    public function getHeaders(): CollectionInterface
    {
        return $this->headers;
    }

    /**
     * Set the value of headers.
     */
    public function setHeaders(CollectionInterface $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set the value of files.
     */
    public function setFiles(CollectionInterface $files): self
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get the value of sanitizer.
     */
    public function getSanitizer(): Sanitizer
    {
        return $this->sanitizer;
    }

    /**
     * Set the value of sanitizer.
     */
    public function setSanitizer(Sanitizer $sanitizer): self
    {
        $this->sanitizer = $sanitizer;

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): HttpStatus
    {
        return $this->status;
    }

    public function setStatus(HttpStatus $status): self
    {
        $this->status = $status;

        return $this;
    }
}
